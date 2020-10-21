<?php

use Illuminate\Database\Seeder;
use App\Product;
use Illuminate\Support\Facades\DB;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carts = array(
                        'T-shirt' => 10.99,
                         'Pants'  => 14.99 ,
                         'Jacket' => 19.99 ,
                          'Shoes' => 24.99
                        );

        foreach ($carts as $kay => $value) {
            DB::table('products')->insert([
                'name' => $kay,
                'price' => $value,
            ]);
        }
    }
}
