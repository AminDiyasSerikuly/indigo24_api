<?php

namespace App\Http\Controllers\api;

use App\Order;
use App\Product;
use App\UserProduct;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use phpDocumentor\Reflection\Types\Object_;

class ProductController extends Controller
{

    public function buy(Request $request)
    {
        $redis = Redis::connection();
        $userBalance = \Auth::user()->balance;

        if ($request->total_price > $userBalance) {
            return response(['message' => 'У вас недостаточно баланса']);
        }

        $rules = [
            'product_id' => 'required',
            'quantity' => 'required',
        ];

        $message = [
            'product_id.required' => 'required product_id',
            'quantity.required' => 'required quantity',
        ];

        $validator = \Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()]);
        }

        $productExist = UserProduct::where(['user_id' => \Auth::user()->id, 'product_id' => $request->product_id])->get();
        if (count($productExist)) {
            return response(['message' => 'Вы уже имеете этот продукт']);
        }


        $tempProducts = json_decode($redis->get('temp_products'));

        if (!count($tempProducts)) {
            $tempProducts = [];
        }


        $product = Product::where(['id' => $request->product_id])->first();
        $total_price = ($product->price) * $request->quantity;

        $newProducts = [
            'user_id' => \Auth::user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'created_at' => date('Y:m:d H:m:i'),
        ];

        array_push($tempProducts, $newProducts);
        $redis->set('temp_products', json_encode($tempProducts));


        return response(['message' => 'Ваши данные успешно сохранены', 'data' => $tempProducts]);
    }

    /** @var Request $request */
    public function show()
    {
        $id = \Auth::user()->id;
        $userProducts = UserProduct::where(['user_id' => $id])->get();
        $productArray = array();

        if (!count($userProducts)) {
            return response(['message' => 'У пользователя нету продуктов']);
        }
        foreach ($userProducts as $userProduct) {
            $item = [];
            if ($userProduct->product) {
                $item['user_id'] = $userProduct->user->id;
                $item['name'] = $userProduct->product->name;
                $item['price'] = $userProduct->product->price;
                $item['weight'] = $userProduct->product->weight;

                array_push($productArray, $item);
            }
        }
        return response(['user_products' => (object)$productArray]);
    }
}
