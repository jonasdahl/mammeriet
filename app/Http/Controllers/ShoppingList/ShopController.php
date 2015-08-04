<?php

namespace App\Http\Controllers\ShoppingList;

use Illuminate\Routing\Controller as BaseController;
use App\ShoppingList;
use App\Product;

class ShopController extends BaseController
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

    /**
     * Shows list page.
     *
     * @param $id, the id of the list
     * @return Response, a view for showing a specific list page.
     */
    public function getIndex() 
    {
        return view('shop.shop');
    }

    /**
     * Shows list page.
     *
     * @param $id, the id of the list
     * @return Response, a view for showing a specific list page.
     */
    public function getDoneProduct($id) 
    {
        $product = Product::find($id);
        $product->status = 'done';
        $product->save();

        return redirect('list/show/' . $product->list);
    }
}
