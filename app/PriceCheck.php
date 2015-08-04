<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class PriceCheck extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pricecheck';

    /**
     * The product to be checked.
     *
     * @return Relationship to product.
     */
    public function productInfo() {
        return $this->hasOne('App\Product', 'id', 'product');
    }
}
