<?php
namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\Mail\StoreRegisteredMail;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller
{
    // Method to store a new store
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'postal_code' => 'required|regex:/^\d{7}$/',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'link' => 'nullable|url|max:255',
            'category_id' => 'required|exists:categories,category_name',
            'phone' => 'nullable|string|max:20',
        ]);
		$category_id = Category::where('category_name', $request->category_id)->first()->id;

		if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get address from postal code if not provided
        if (!$request->has('address')) {
            $addressData = $this->getAddressFromPostalCode($request->postal_code);
            if ($addressData) {
                $request->merge(['address' => $addressData['address']]);
            } else {
                return response()->json(['error' => 'Invalid postal code'], 400);
            }
        }

        // Get lat/lng from the address
        $coordinates = $this->getCoordinatesFromAddress($request->address);
        if (!$coordinates) {
            return response()->json(['error' => 'Failed to retrieve coordinates'], 400);
        }

        // Create a new store
        $store = Store::create([
            'name' => $request->name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'lat' => $coordinates['lat'],
            'lng' => $coordinates['lng'],
            'email' => $request->email,
            'link' => $request->link,
            'category_id' => $category_id,
            'phone' => $request->phone,
            'approval_flag' => 0, // By default set to not approved
            'display_flag' => 0,  // By default set to not displayed
        ]);
		// Send a confirmation email after the store is registered
		Mail::to("t.morita.logic@gmail.com")->send(new StoreRegisteredMail($store));

        // Return success response
        return response()->json(['message' => 'Store registered successfully', 'store' => $store], 201);
    }

    // Function to get address from postal code using ZipCloud API
    private function getAddressFromPostalCode($postalCode)
    {
        $url = 'https://zipcloud.ibsnet.co.jp/api/search';
        $client = new Client();
        $response = $client->get($url, [
            'query' => ['zipcode' => $postalCode]
        ]);

        $data = json_decode($response->getBody(), true);
        if ($data['status'] === 200 && isset($data['results'][0])) {
            $address = $data['results'][0];
            return [
                'address' => $address['address1'] . $address['address2'] . $address['address3']
            ];
        }

        return null;
    }

    // Function to get coordinates from the address using Google Maps API
    private function getCoordinatesFromAddress($address)
    {
        $apiKey = 'AIzaSyDEfwfDr0RT5xanUbNo-KY4m8QV_Zl4y6U';
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $client = new Client();
        $response = $client->get($url, [
            'query' => ['address' => $address, 'key' => $apiKey]
        ]);

        $data = json_decode($response->getBody(), true);
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
