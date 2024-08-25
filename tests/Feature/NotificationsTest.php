<?php

use App\Notifications\NewProductionNotification;
use Illuminate\Support\Facades\Notification;


it( 'should sends a notification about a new product', function () {
    Notification::fake();

    $user = \App\Models\User::factory()->create();

    \Pest\Laravel\actingAs( $user );

    \Pest\Laravel\postJson(
        route( 'product.store', [
                'title'    => 'Test product',
                'price'    => 20,
                'owner_id' => $user->id
            ]
        ) )->assertSuccessful();

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductionNotification::class);
} );