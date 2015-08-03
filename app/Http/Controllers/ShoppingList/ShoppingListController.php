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
     * @return Response, a view for showing a specific list page.
     */
    public function getShow($id) 
    {
        return view('lists.list')
            ->with('list', ShoppingList::find(1));
    }
}
