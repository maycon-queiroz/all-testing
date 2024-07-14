<?php

test( 'testing status 200' )
    ->get( '/' )
    ->assertStatus( 200 )
    ->assertOk();

test( 'testing status 404' )
    ->get( '/404' )
    ->assertStatus( 404 )
    ->assertNotFound();

test( 'testing status 403' )
    ->get( '/403' )
    ->assertStatus( 403 )
    ->assertForbidden();