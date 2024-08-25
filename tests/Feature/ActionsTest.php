<?php

use App\Actions\CreateProductAction;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\postJson;

it('should call the action to create a product', function () {
    Notification::fake();

    $this->mock(CreateProductAction::class)
    ->shouldReceive('handle')
    ->atLeast()->once();

    $user = \App\Models\User::factory()->create();
    \Pest\Laravel\actingAs($user);

    postJson(
        route( 'product.store', [
                'title'    => 'Test product',
                'price'    => 20,
                'owner_id' => $user->id
            ]
        ) )->assertSuccessful();
});