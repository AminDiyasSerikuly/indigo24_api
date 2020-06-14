<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($var = 1; $var <= 100; $var++) {
            DB::table('products')->insert([
                'name' => ('product' . $var),
                'price' => (100 * $var),
                'weight' => (200 * $var),
                'created_at' => date('Y:m:d H:m:i'),
            ]);
        }
    }
}
