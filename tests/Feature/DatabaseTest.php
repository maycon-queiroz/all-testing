<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

it( 'should be able to create a product', function () {
    $user = \App\Models\User::factory()->create();
    postJson(
        route( 'product.store' ),
        [
            'title' => 'Test product',
            'price' => 20,
            'owner_id'=>$user->id
        ] )
        ->assertCreated();

    assertDatabaseHas('products',[
        'title' => 'Test product',
    ]);

    assertTrue(
        \App\Models\Product::query()
        ->where('title', '=','Test product')
        ->exists()
    );

    assertDatabaseCount('products', 1);
} );

it( 'should be able to update a product', function () {
    $user = \App\Models\User::factory()->create();

    $product = \App\Models\Product::factory()->create([
        'title' => 'Test product',
        'price' => 20,
        'owner_id'=>$user->id
        ]);

    \Pest\Laravel\putJson(route('product.update', $product),[
        'title' => 'Update  product title',
    ])->assertOk();

    assertDatabaseHas('products', [
        'id' => $product->id,
        'title' => 'Update  product title'
    ]);

    /** always to use 'refresh' when using expect and assertSame */
    expect($product)
        ->refresh()
        ->title->toBe('Update  product title');

    assertSame('Update  product title', $product->title);

    assertDatabaseCount('products', 1);

} );

it( 'should be able to delete a product', function () {
    $product = \App\Models\Product::factory()->create();

    \Pest\Laravel\delete(route('product.destroy', $product))
    ->assertOk();

    assertDatabaseCount('products', 0);
    assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
} );

it( 'should be able to soft-delete a product', function () {
    $product = \App\Models\Product::factory()->create();

    \Pest\Laravel\delete(route('product.soft-delete', $product))
        ->assertOk();

    assertDatabaseCount('products', 1);
    \Pest\Laravel\assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
} );