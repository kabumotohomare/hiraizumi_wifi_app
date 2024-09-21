<?php

namespace App\Admin\Controllers;

use App\Models\PublicFacility;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use GuzzleHttp\Client;

class PublicFacilityController extends AdminController
{
    protected $title = '公共施設情報';

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

        return null;
    }

    protected function grid()
    {
        $grid = new Grid(new PublicFacility());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('施設名'))->sortable()->filter('like');
        $grid->column('postal_code', __('郵便番号'))->filter('like');
        $grid->column('address', __('住所'))->filter('like');
        $grid->column('phone', __('電話番号'))->sortable();

        // Add map link using latitude and longitude
        $grid->column('map', __('Map'))->display(function () {
            if ($this->lat && $this->lng) {
                $mapUrl = "https://maps.google.com/maps?ll={$this->lat},{$this->lng}&z=16&q={$this->lat},{$this->lng}";
                return "<a href='$mapUrl' target='_blank'>View Map</a>";
            }
            return 'No location data';
        })->sortable(false);

        $grid->column('display_flag', __('表示可否'))->switch()->filter([0 => '非表示', 1 => '表示中']);
        $grid->column('reservation_flag', __('予約可否'))->switch()->filter([0 => '予約不可', 1 => '予約可']);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new PublicFacility());

        $form->text('name', __('施設名'))->required();
        $form->text('postal_code', __('郵便番号'))->required()
            ->creationRules(['required', 'regex:/^\d{7}$/'])  // Enforce 7-digit postal code
            ->updateRules(['required', 'regex:/^\d{7}$/']);
        $form->text('address', __('住所')); // Auto-filled from postal code
        $form->decimal('lat', __('緯度'))->readonly(); // Auto-filled from address
        $form->decimal('lng', __('経度'))->readonly(); // Auto-filled from address
        $form->text('phone', __('電話番号'))->required();
        $form->switch('display_flag', __('表示可否'))->default(false);
        $form->switch('reservation_flag', __('予約可否'))->default(false);

        $form->html(view('admin.js'));  // Load the JavaScript for postal code lookup

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

    // Function to get coordinates from the address using Google Maps API
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
