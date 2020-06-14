<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Amin',
            'email' => 'amindiyass@gmail.com',
            'password' => Hash::make('helloWorld'),
            'balance' => 10000,
            'created_at' => now(),
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'helloWorld',
            'email' => 'helloWorld@gmail.com',
            'password' => Hash::make('helloWorld'),
            'balance' => 500,
            'created_at' => now(),
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'darkNet',
            'email' => 'darkNet@gmail.com',
            'password' => Hash::make('helloWorld'),
            'balance' => 2000,
            'created_at' => now(),
        ]);
    }
}
