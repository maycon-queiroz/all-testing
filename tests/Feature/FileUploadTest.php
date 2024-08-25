<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('should be able to upload an image', function () {
   Storage::fake('avatar');

   $user = User::factory()->create();

   actingAs($user);

   $file = UploadedFile::fake()->image('avatar.jpg');

   post(route('upload-avatar'),['file'=>$file])->assertOk();

   Storage::disk('avatar')->assertExists($file->hashName());
});

it( 'should be able to import as csv file', function () {
    $user = User::factory()->create();

    actingAs($user);

    $data = <<<txt
        product 1, 110, 1,
        product 2, 120, 1,
        product 3, 150, 1,
        txt;

    $file = UploadedFile::fake()->createWithContent('product.csv',$data);

    post(route('upload-import-csv'),['file'=>$file])->assertOk();

    \Pest\Laravel\assertDatabaseHas('products', ['title'=> 'product 1']);
    \Pest\Laravel\assertDatabaseHas('products', ['title'=> 'product 2']);

    \Pest\Laravel\assertDatabaseCount('products', 3);
} );