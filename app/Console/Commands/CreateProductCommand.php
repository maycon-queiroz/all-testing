<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title?} {price?} {owner?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): void
    {
        /** @var User|null $user */
        $user = $this->argument( 'owner' );
        $title = $this->argument( 'title' );
        $price = $this->argument( 'price' );

        if (!$user) {
            $user = $this->components->ask( 'Please, provide a valid user id' );
        }
        if (!$title) {
            $title = $this->components->ask( 'Please, provide a valid title' );
        }
        if (!$price) {
            $price = $this->components->ask( 'Please, provide a valid price' );
        }

        Product::query()
        ->create([
            'title' => $title,
            'price' => $price,
            'owner_id' => $user
        ]);


        $this->components->info( 'Product created successfully' );
    }
}
