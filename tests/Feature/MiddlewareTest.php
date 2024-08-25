<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('should block a request if the user does not have the following email: maycon@maycon.com', function () {
    $user = User::factory()->create();
    $maycon = User::factory()->create(['email' => 'maycon@maycon.com']);

    actingAs($user);
    post(route('secure-route'))->assertForbidden();

    actingAs($maycon);
    post(route('secure-route'))->assertOk();
});
