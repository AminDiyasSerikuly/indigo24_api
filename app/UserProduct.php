<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'user_product';


    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne('App\Product', 'id', 'user_id');
    }


}
