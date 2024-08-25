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
    ] );

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductionNotification::class);
} );