<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Models\PublicFacility;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function index()
    {
        // Fetch stores with their category where the display_flag is true
        $stores = Store::with('category')
            ->where('display_flag', true)
            ->get()  // This returns a collection
            ->map(function ($store) {
                return [
                    'id' => $store->id,
                    'name' => $store->name,
                    'lat' => $store->lat,
                    'lng' => $store->lng,
                    'email' => $store->email,
                    'link' => $store->link,
                    'category' => $store->category->category_name,
                    'phone' => $store->phone,
                ];
            });

        // Fetch public facilities where the display_flag is true
        $publicFacilities = PublicFacility::where('display_flag', true)
			->get()
            ->map(function ($facility) {
                return [
                    'id' => $facility->id,
                    'name' => $facility->name,
                    'lat' => $facility->lat,
                    'lng' => $facility->lng,
                    'email' => $facility->email,
                    'link' => $facility->link,
                    'category' => '公共施設',  // Fixed category name for public facilities
                    'phone' => $facility->phone,
                ];
            });

        // Merge stores and public facilities
        $spots = $stores->merge($publicFacilities);

        // Return as JSON
        return response()->json($spots);
    }
}
