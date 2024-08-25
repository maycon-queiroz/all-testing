<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;
use App\Notifications\NewProductionNotification;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it( 'should be able create a product from command', function () {
    Notification::fake();

    $user = User::factory()->create();
    $data = [
        'title'    => 'Test product',
        'price'    => 20,
        'owner' => $user
    ];
    artisan(
        CreateProductCommand::class,
        $data
    )->assertSuccessful();

    assertDatabaseCount( 'products', 1 );
    assertDatabaseHas( 'products', [
        'title'    => 'Test product',
        'price'    => 20,
        'owner_id' => $user->id
    ] );

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductionNotification::class);
} );

it( 'should asks for user and title if not provide as arguments', function () {
    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])
        ->expectsQuestion('Please, provide a valid user id', $user->id)
        ->expectsQuestion('Please, provide a valid title', 'Product title 1')
        ->expectsQuestion('Please, provide a valid price', 20)
        ->expectsOutputToContain('Product created successfully')
        ->assertSuccessful();
});