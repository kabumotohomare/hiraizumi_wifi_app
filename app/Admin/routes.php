<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\StoreController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\PublicFacilityController;
use App\Admin\Controllers\TemporaryPublicFacilityReservationController;
use App\Admin\Controllers\ConfirmedPublicFacilityReservationController;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    
    // Store and Category routes
    $router->resource('stores', StoreController::class);
    $router->resource('categories', CategoryController::class);
    
    // Public Facility Management
    $router->resource('public-facilities', PublicFacilityController::class);
    
    // Temporary Public Facility Reservation
    $router->resource('temporary-publicfacility', TemporaryPublicFacilityReservationController::class);
    
    // Confirmed Public Facility Reservation
    $router->resource('confirmed-publicfacility', ConfirmedPublicFacilityReservationController::class);
});
