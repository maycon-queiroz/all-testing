<?php

use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it( 'should dispatch a job to the queue', function () {
    Queue::fake();
    $user = \App\Models\User::factory()->create();
    actingAs( $user );

    postJson( route( 'product.import' ), [
        'data' => [
            ['title' => 'product 1'],
            ['title' => 'product 2'],
            ['title' => 'product 3'],
        ]
    ] );

    Queue::assertPushed( ImportProductJob::class );
} );

it( 'should be able found product insert from a job', function () {
    Queue::fake();

    $user = \App\Models\User::factory()->create();
    actingAs( $user );

    $data = [
        ['title' => 'product 1', 'price' => 100],
        ['title' => 'product 2', 'price' => 102],
        ['title' => 'product 3', 'price' => 104],
    ];

    (new ImportProductJob($data, $user->id))->handle();

    assertDatabaseCount( 'products', 3 );
    assertDatabaseHas( 'products', ['title' => 'product 1'] );
    assertDatabaseHas( 'products', ['title' => 'product 2'] );
    assertDatabaseHas( 'products', ['title' => 'product 3'] );
} );