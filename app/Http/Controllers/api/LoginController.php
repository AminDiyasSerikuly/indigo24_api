<?php

namespace App\Http\Controllers\api;

use App\Order;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Object_;
use function MongoDB\BSON\toJSON;
use function MongoDB\BSON\toPHP;

class LoginController extends Controller
{
    /** @var Request $request */

    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);


        if (!\Auth::attempt($login)) {
            return response(['message' => 'Неправильный email или пароль.']);
        }
        $user_orders = Order::where(['user_id' => \Auth::user()->id])->get();
        $orders = array();
        foreach ($user_orders as $order) {
            $orders[$order->product->id] = $order->product->name;
        }

        $user = array_merge(\Auth::user()->toArray(), ['order' => $orders]);


        $token = \Auth::user()->createToken('authToken')->accessToken;


        return response(['user' => $user, 'access_token' => $token]);

    }
}
