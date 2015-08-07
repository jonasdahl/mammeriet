<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\PriceCheck;
use DB;

class ProductApiController extends BaseController
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
        $res = new \StdClass;
        $res->done = $product->status != 'done';
        if ($res->done)
            $product->status = 'done';
        else 
            $product->status = '';
        $product->save();

        $res->list = new \StdClass;
        $res->list->done_products = round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->where('list', '=', $product->shoppingList->id)->where('status', 'done')->first()->product_sum);
        $res->list->all_products = round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->where('list', '=', $product->shoppingList->id)->first()->product_sum);
        $res->list->budget = round($product->shoppingList->budget);

        return response()->json($res);
    }
}
