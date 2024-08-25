<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNotification;

class CreateProductAction
{
    public function __construct() {}

    public function handle(array $data, User $user): void
    {
        $products = new Product();
        $products->title = $data['title'];
        $products->price = $data['price'];
        $products->owner_id = $user->id;
        $products->save();

        $user->notify(new NewProductionNotification());
    }
}