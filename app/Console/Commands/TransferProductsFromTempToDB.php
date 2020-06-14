<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TransferProductsFromTempToDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:fromTempToDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer product data from temporary (redis) to data base';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redis = Redis::connection();
        $tempProducts = json_decode($redis->get('temp_products'));
        foreach ($tempProducts as $product) {
            DB::table('user_product')->insert([
                'user_id' => $product->user_id,
                'product_id' => $product->product_id,
            ]);

            DB::table('orders')->insert([
                'user_id' => $product->user_id,
                'product_id' => $product->product_id,
                'total_price' => $product->total_price,
                'quantity' => $product->quantity,
            ]);
        }

        $redis->del('temp_products');
    }
}
