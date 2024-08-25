<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use App\Notifications\NewProductionNotification;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should call the action to create a product', function () {
    Notification::fake();

    $this->mock(CreateProductAction::class)
    ->shouldReceive('handle')
    ->atLeast()->once();

    $user = User::factory()->create();
    actingAs($user);

    postJson(
        route( 'product.store', [
                'title'    => 'Test product',
                'price'    => 20,
                'owner_id' => $user->id
            ]
        ) )->assertSuccessful();
});

it( 'should be able to create a product with action product', function () {
    Notification::fake();

    $user = User::factory()->create();

    $data =  [
        'title'    => 'Test product',
        'price'    => 20,
        'owner_id' => $user->id
    ];

    (new CreateProductAction())->handle($data, $user);

    assertDatabaseCount('products', 1);
    assertDatabaseHas('products', $data);

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductionNotification::class);
} );