<?php

namespace App\Admin\Controllers;

use App\Models\Store;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use GuzzleHttp\Client;

class StoreController extends AdminController
{
    protected $title = '店舗情報';

    // Function to get address from postal code using the ZipCloud API
    private function getAddressFromPostalCode($postalCode)
    {
        // ZipCloud API endpoint
        $url = 'https://zipcloud.ibsnet.co.jp/api/search';

        // GuzzleHTTP client
        $client = new Client();

        // Send the request
        $response = $client->get($url, [
            'query' => [
                'zipcode' => $postalCode
            ]
        ]);

        // Decode the JSON response
        $data = json_decode($response->getBody(), true);

        // If the status is OK, return the address
        if ($data['status'] === 200 && isset($data['results'][0])) {
            $address = $data['results'][0];
            return [
                'address' => $address['address1'] . $address['address2'] . $address['address3'],
                'prefecture' => $address['address1'], // 都道府県
                'city' => $address['address2'], // 市区町村
                'town' => $address['address3'], // 町域
            ];
        }

        // Return null if the lookup failed
        return null;
    }

    protected function grid()
    {
        $grid = new Grid(new Store());
    
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->sortable()->filter('like');
        $grid->column('postal_code', __('Postal Code'))->filter('like');
        $grid->column('address', __('Address'))->filter('like');
        $grid->column('category_id', 'Category')->display(function ($categoryId) {
            return Category::find($categoryId)->category_name;
        })->sortable()->filter('like');
        
        // Add a column for the map link using the latitude and longitude
        $grid->column('map', __('Map'))->display(function () {
            if ($this->lat && $this->lng) {
                $mapUrl = "https://maps.google.com/maps?ll={$this->lat},{$this->lng}&z=16&q={$this->lat},{$this->lng}";
                return "<a href='$mapUrl' target='_blank'>View Map</a>";
            }
            return 'No location data';
        })->sortable(false);
    
        $grid->column('approval_flag', __('Approval Flag'))->switch()->filter([
            0 => '未承認',
            1 => '承認済み'
        ]);
        $grid->column('display_flag', __('Display Flag'))->switch()->filter([
            0 => '非表示',
            1 => '表示中'
        ]);
    
        return $grid;
    }    

    protected function form()
    {
        $form = new Form(new Store());
    
        $form->text('name', __('Name'))->required();
        $form->text('postal_code', __('Postal Code'))->required()
            ->creationRules(['required', 'regex:/^\d{7}$/']) // Enforce 7-digit postal code
            ->updateRules(['required', 'regex:/^\d{7}$/']);
    
        $form->text('address', __('Address')); // Auto-filled from postal code
        $form->decimal('lat', __('Lat'))->readonly(); // Auto-filled from address
        $form->decimal('lng', __('Lng'))->readonly(); // Auto-filled from address
        $form->email('email', __('Email'));
        $form->url('link', __('Link'));
        $form->select('category_id', 'Category')->options(Category::all()->pluck('category_name', 'id'));
        $form->text('phone', __('Phone'));
        $form->switch('approval_flag', __('Approval Flag'));
        $form->switch('display_flag', __('Display Flag'));
    
        // Load the partial view containing JavaScript code
        $form->html(view('admin.js'));
        $form->saving(function (Form $form) {
            if ($form->address) {
                $coordinates = $this->getCoordinatesFromAddress($form->address);
                if ($coordinates) {
                    $form->lat = $coordinates['lat'];
                    $form->lng = $coordinates['lng'];
                } else {
                    admin_error('Error', 'Failed to retrieve address from postal code.');
                }    
            }
        });
    
        return $form;
    }
    
    // Function to get coordinates from the address
    private function getCoordinatesFromAddress($address)
    {
        // Google Maps API key
        $apiKey = 'AIzaSyDEfwfDr0RT5xanUbNo-KY4m8QV_Zl4y6U';

        // Google Geocoding API endpoint
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        // GuzzleHTTP client
        $client = new Client();

        // Send the request
        $response = $client->get($url, [
            'query' => [
                'address' => $address,
                'key' => $apiKey
            ]
        ]);

        // Decode the JSON response
        $data = json_decode($response->getBody(), true);

        // If the status is OK, return the latitude and longitude
        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return [
                'lat' => $location['lat'],
                'lng' => $location['lng']
            ];
        }

        return null;
    }
}
