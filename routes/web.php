<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::get( '/403', function () {
    abort_if( true, 403 );

    return ['oi'];
} );

Route::get( '/products', function () {
    $products = Product::all();
    return view( 'products', compact( 'products' ) );
} );

Route::post( '/products', function () {
    $data = request()->all();
    $products = new Product();
    $products->title =$data['title'];
    $products->price =$data['price'];
    $products->save();

    return response()->json('',201);
} )->name('product.store');