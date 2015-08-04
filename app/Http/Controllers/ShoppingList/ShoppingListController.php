<?php

namespace App\Http\Controllers\ShoppingList;

use Illuminate\Routing\Controller as BaseController;
use App\ShoppingList;
use App\Product;
use Illuminate\Http\Request;

class ShoppingListController extends BaseController
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
    public function getShow($id) 
    {
        return view('lists.list')
            ->with('list', ShoppingList::find($id));
    }

    /**
     * Shows form to add a product into list $id.
     *
     * @param $id, the id of the list
     * @return Response, a view for showing a specific list page.
     */
    public function getAddProduct($id) 
    {
        return view('lists.addproduct')
            ->with('list', ShoppingList::find($id));
    }

    /**
     * Adds product into list.
     *
     * @param $id, the id of the list
     * @return Response, a view for showing a specific list page.
     */
    public function postAddProduct(Request $request) 
    {
        $list = ShoppingList::find($request->input('id'));
        $product = new Product;
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->unitprice = $request->input('unitprice');
        $product->list = $list->id;
        $product->save();

        return redirect('list/show/' . $list->id)
            ->with('success', 'Produkten lades till.');
    }
}
