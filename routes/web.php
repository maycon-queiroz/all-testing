<?php

use App\Actions\CreateProductAction;
use App\Http\Middleware\MayconMiddleware;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
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
    request()->validate( ['title' => ['required', 'string', 'max:255']] );

    $user = auth()->user();

    $data = request()->all();

    $action = app( CreateProductAction::class);
    $action->handle($data,$user);

    return response()->json( '', 201 );
} )->name( 'product.store' );

Route::put( '/products/{product}', function (Product $product) {
    $data = request()->all();

    $product->title = $data['title'];
    $product->save();

    return response()->json( '', 200 );
} )->name( 'product.update' );

Route::delete( '/products/{product}', function (Product $product) {
    $product->forceDelete();
    return response()->json( '', 200 );
} )->name( 'product.destroy' );

Route::delete( '/products/soft-delete/{product}', function (Product $product) {
    $product->delete();
    return response()->json( '', 200 );
} )->name( 'product.soft-delete' );

Route::post( 'send-email/{user}', function (User $user) {
    Mail::to( $user )->send( new WelcomeEmail( $user ) );
} )->name( 'sending-email' );

Route::post( 'import-products', function () {
    $data = request()->get( 'data' );

    $user = auth()->user();
    \App\Jobs\ImportProductJob::dispatch( $data ,$user->id);
} )->name( 'product.import' );

Route::middleware(MayconMiddleware::class)
    ->post( 'secure-user', fn ()=>['oi'])
    ->name( 'secure-route' );