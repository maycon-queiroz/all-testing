<?php

use App\Models\Product;
use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function (){
    $user = \App\Models\User::factory()->create();
    $product = \App\Models\Product::factory()->create(['owner_id' => $user->id]);

    $owner = $product->owner;

    expect($owner)
        ->toBeInstanceOf(\App\Models\User::class);
});

test( 'model get mutator :: product title should always be str()->title()', function () {
    $product = Product::factory()->create(['title' => 'test']);

    expect($product->title)->toBe('Test');
} );

test( 'model set mutator :: product code should be encrypted', function () {
    $product = Product::factory()->create(['code' => 'test']);

    assertTrue(\Illuminate\Support\Facades\Hash::isHashed($product->code));
} );

test('model scopes :: should bring only released products', function () {
    Product::factory()->count(10)->create(['released' => true]);
    Product::factory()->count(5)->create(['released' => false]);

    expect(Product::query()->released()->get())->toHaveCount(10);

});