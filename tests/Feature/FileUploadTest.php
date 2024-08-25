<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

test('should be able to upload an image', function () {
   Storage::fake('avatar');

   $user = User::factory()->create();

   actingAs($user);

   $file = UploadedFile::fake()->image('avatar.jpg');

   post(route('upload-avatar'),['file'=>$file])->assertOk();

   Storage::disk('avatar')->assertExists($file->hashName());
});
