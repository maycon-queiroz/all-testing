<?php

test('model relationship :: product owner should be an user', function (){
    $user = \App\Models\User::factory()->create();
    $product = \App\Models\Product::factory()->create(['owner_id' => $user->id]);

    $owner = $product->owner;

    expect($owner)
        ->toBeInstanceOf(\App\Models\User::class);
});
