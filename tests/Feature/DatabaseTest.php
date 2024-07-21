<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertTrue;

it( 'should be able to create a product', function () {
    postJson(
        route( 'product.store' ),
        [
            'title' => 'Test product',
            'price' => 20
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

it( 'should be able to update a product', function () {} )->todo();


it( 'should be able to delete a product', function () {} )->todo();