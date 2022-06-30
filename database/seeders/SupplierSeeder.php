<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'name' => 'supplier Ahmed',
            'phone' => '01145487999',
            'email' => 'supplier_ahmed@gmail.com',
        ]);
    }
}
