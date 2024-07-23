<?php

test('product :: title should be required', function () {
    \Pest\Laravel\postJson(route('product.store'), ['title'=>'',  'price'=>20])
    ->assertInvalid(['title'=> 'required']);

    \Pest\Laravel\post(route('product.store'), ['title'=>'',  'price'=>20])
        ->assertInvalid(['title'=> 'required']);
});

test( 'product :: title should have a max of 255 characters', function () {
    \Pest\Laravel\postJson(route('product.store'), [
        'title'=> str_repeat('a', 256),
        'price'=>20
    ])
        ->assertInvalid([
            'title'=> __('validation.max.string', ['attribute'=>'title','max' => 255])
        ]);
} );