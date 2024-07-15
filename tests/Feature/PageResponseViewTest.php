<?php

test( 'route product should return view product' )
    ->get( '/products' )
    ->assertViewIs( 'products' );

test( 'route product is passed a list products' )
    ->get( '/products' )
    ->assertViewIs( 'products' )
    ->assertViewHas( 'products' );