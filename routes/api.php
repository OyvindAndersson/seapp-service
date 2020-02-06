<?php

use Illuminate\Http\Request;
use App\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['guest:api']], function () {
    Route::post('login', 'ApiAuthController@login');
    Route::post('signup', 'ApiAuthController@signup');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/products', 'ProductController@index');
Route::middleware('auth:api')->post('/products', 'ProductController@store');

Route::middleware('auth:api')->get('/products/make', function(){
    $product = \DB::transaction( function() {
        $product = factory('App\Product')->create();

        $unitType = factory('App\UnitType')->create();

        $price = App\PriceDescription::make([
            'unit_price' => 123.5,
            'is_historic' => false,
            'unit_type_id' => $unitType->id,
        ]);

        $files = factory('App\File', 3)->make();
        foreach($files as $file)
        {
            $product->files()->save($file);
        }

        $product->prices()->save($price);

        $product->price()->associate($price);
        $product->save();

        return $product;
    });
    
    $product = Product::where('id', $product->id)->first();

    return response()->json($product);
});
/*

*/
