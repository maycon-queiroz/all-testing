<?php

use function Pest\Laravel\get;

it('should list product')
->get('/products')
->assertOk()
->assertSeeTextInOrder([
    'produto A',
    'produto B',
]);

it('should list all product', function(){
    $product1 = \App\Models\Product::factory()->create();
    $product2 = \App\Models\Product::factory()->create();

    get('/products')
    ->assertOk()
    ->assertSeeTextInOrder([
        'produto A',
        'produto B',
        $product1->title,
        $product2->title,
    ]);
});