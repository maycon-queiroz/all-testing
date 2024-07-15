<?php

use function Pest\Laravel\get;

test('should be able to get products')
->get('/api/products')
->assertOk()
->assertJson([
    ['title'=>'produto A'],
    ['title'=>'produto B'],
]);

test( 'should be able list product',
    function () {
        $product1 = \App\Models\Product::factory()->create();
        $product2 = \App\Models\Product::factory()->create();

        get( '/api/products' )
            ->assertOk()
            ->assertJson( [
                ['title'=>'produto A'],
                ['title'=>'produto B'],
                ['title'=> $product1->title],
                ['title'=> $product2->title],
            ] );
    } );