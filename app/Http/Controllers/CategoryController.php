<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('display_flag', true)
                              ->get(['category_name', 'color_code'])
                              ->toArray();

        // Add the "公共施設" category with "purple-pink" color
        $categories[] = [
            'category_name' => '公共施設',
            'color_code' => 'purple-pink'
        ];

        return response()->json($categories);
    }
}
