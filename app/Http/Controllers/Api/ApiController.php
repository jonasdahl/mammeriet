<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\PriceCheck;

class ApiController extends BaseController
{

    /**
     * Create a new user controller instance.
     * Everything needs user to be logged in.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function getSetDone($id) {
        $product = Product::find($id);
        $product->status = 'done';
        $product->save();

        return response()->json(true);
    }
}
