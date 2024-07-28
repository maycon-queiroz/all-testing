<?php

use App\Mail\WelcomeEmail;
use App\Models\User;

test( 'an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    \Pest\Laravel\post( route( 'sending-email', $user ) )
        ->assertOk();

    Mail::assertSent( WelcomeEmail::class );

} );

