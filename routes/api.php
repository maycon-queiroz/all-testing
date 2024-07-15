<?php

use App\Models\Product;

Route::get('/products', function (){
    $products = Product::all();
    $products->map(fn($p)=>['title'=>$p->title]);

   return array_merge([
       ['title'=>'produto A'],
       ['title'=>'produto B'],
   ], $products->toArray());
});