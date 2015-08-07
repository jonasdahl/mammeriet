<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\PriceCheck;
use App\ShoppingList;
use DB;

class ListApiController extends BaseController
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

    public function getProductsStatus($id) {
        $res = new \StdClass;
        $res->list = new \StdClass;
        $res->list->done_products = round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->whereNull('deleted_at')->where('list', '=', $id)->where('status', 'done')->first()->product_sum);
        $res->list->all_products = round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->whereNull('deleted_at')->where('list', '=', $id)->first()->product_sum);
        $res->list->budget = round(ShoppingList::find($id)->budget);

        $products = Product::where('list', '=', $id)->get();
        $res->statuses = [];
        $res->product_info = [];
        foreach($products as $product) {
            $res->statuses[$product->status][] = $product->id;
            $p = new \StdClass;
            $p->id = $product->id;
            $p->name = $product->name;
            $p->unitprice = $product->unitprice;
            $p->quantity = $product->quantity;
            $p->moms = $product->moms;
            $res->product_info[] = $p;
        }

        $res->deleted_products = [];
        foreach (DB::table('products')->where('list', '=', $id)->whereNotNull('deleted_at')->get() as $p) {
            $res->deleted_products[] = $p->id;
        }

        return response()->json($res);
    }

    public function getShow($id) {
        $list = ShoppingList::find($id);
        $products = $list->products()->orderBy('status')->orderBy('name')->get();

        return response()->json($products);
    }
}
