<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = Order::create([
            'date' => date("Y-m-d"),
            'customer_id' => Customer::first()->id,
            'discount' => 50,
            'notes' => 'Order Notes',
        ]);

        $products_ids = [];

        for($i = 0; $i<3; $i++)
        {
            $product = Product::inRandomOrder()->whereNotIn('id' , $products_ids)->first();
            $order->products()->attach($product->id , [
                'quantity' => $i+1,
                'price' => $product->selling_price,
            ]);

            array_push($products_ids , $product->id);
        }
    }
}
