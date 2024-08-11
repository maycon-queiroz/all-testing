<?php

use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\Queue;
it('should dispatch a job to the queue', function () {
   Queue::fake();

   \Pest\Laravel\postJson(route('product.import'),[
       ['title' => 'product 1'],
       ['title' => 'product 2'],
       ['title' => 'product 3'],
   ]);

   Queue::assertPushed(ImportProductJob::class);
});