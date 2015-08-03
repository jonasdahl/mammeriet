<?php

namespace App\Http\Controllers\ShoppingList;

use Illuminate\Routing\Controller as BaseController;
use App\ShoppingList;

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
}
