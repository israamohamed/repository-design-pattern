<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Backpack']);
        Category::create(['name' => 'Camera']);
        Category::create(['name' => 'Mobile']);

        $names = [
            'Classic Backpack',
            'Goodern Laptop Backpack',
            'Waterproof Travel Bag',
            'Timberland Backpack',
            'Canvas Backpack',

            'Canon EOS 90D',
            'Nikon COOLPIX B500',
            'Nikon Z7 FX-Format',
            'Canon EOS 800D',
            'Xiaomi Mi Home Security',

            'Oppo Reno 6',
            'amsung Galaxy A52s',
            'Samsung Galaxy A52',
            'Reno 6 Black',
            'Nokia 106',

        ];       

        $images = [
            'seeder/b1.jpg',
            'seeder/b2.jpg',
            'seeder/b3.jpg',
            'seeder/b4.jpg',
            'seeder/b5.jpg',

            'seeder/c1.png',
            'seeder/c2.jpg',
            'seeder/c3.jpg',
            'seeder/c4.jpg',
            'seeder/c5.jpg',

            'seeder/m1.jpg',
            'seeder/m2.jpg',
            'seeder/m3.jpg',
            'seeder/m4.jpg',
            'seeder/m5.jpg',
        ];

        $prices = [
            145.00,
            230.00,
            170.00,
            200.00,
            115.00,

            30000.00,
            5750.00,
            63000.00,
            15000.00,
            790.00,

            8575.00,
            7999.00,
            6899.00,
            8666.00,
            451.00




            
        ];

        $count = 0;
        foreach(Category::get() as $index => $category)
        {
            for($i = 0; $i < 5; $i++)
            {
                $p = Product::create([
                        'name'          => $names[$count],
                        'code'          => $count . '222',
                        'category_id'   => $category->id,
                        'supplier_id'   => Supplier::inRandomOrder()->first()->id,
                        'buying_price'  => ($i + 1) * 10,
                        'selling_price' => $prices[$count],
                        'quantity'      => $i + $index * 3
                    ]);
                $p->image()->create(['path' => $images[$count]]);

                $count++;
            }
           
        }
    }
}
