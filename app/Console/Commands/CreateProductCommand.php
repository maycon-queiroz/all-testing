<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title} {price} {owner}';

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
        $data = [
            'title' => $this->argument( 'title' ),
            'price' => $this->argument( 'price' ),
        ];

        /** @var User $user */
        $user = $this->argument( 'owner' );

        $action = app( CreateProductAction::class );
        $action->handle( $data, $user );
    }
}
