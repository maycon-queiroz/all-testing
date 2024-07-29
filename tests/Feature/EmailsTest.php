<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use function Pest\Laravel\post;

test( 'an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    post( route( 'sending-email', $user ) )
        ->assertOk();

    Mail::assertSent( WelcomeEmail::class );

} );

test( 'an email was sent to user::x', function () {
    Mail::fake();

    $user = User::factory()->create();

     post( route( 'sending-email', $user ) )
        ->assertOk();

    Mail::assertSent(
        WelcomeEmail::class,
        fn(WelcomeEmail $mail) => $mail->hasTo( $user->email )
    );

} );

test('an email was sent with a subject', function(){

});
