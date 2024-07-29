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

test( 'email subject should  contain the user name', function () {
    Mail::fake();

    $user = User::factory()->create();

    $email = new WelcomeEmail( $user );

    expect( $email )
        ->assertHasSubject( "thank you for signing up {$user->name}" );
} );

test( 'email content should contain user email in html', function () {
    Mail::fake();

    $user = User::factory()->create();

    $email = new WelcomeEmail( $user );

    expect( $email )
        ->assertSeeInHtml( $user->email )
        ->assertSeeInHtml( "Confirm the your email is {$user->email}" );
} );