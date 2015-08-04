<?php

namespace App\Http\Controllers\ShoppingList;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\ShoppingList;
use App\Product;
use DB;

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
        if (DB::table('daylist')->where('day', '=', date("Y-m-d"))->count() == 0)
            return view('shop.shop');
        return redirect('shop/list/' . date('Y-m-d'));
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

        return redirect('shop/list/' . date("Y-m-d"));
    }

    /**
     * Adds events to get parameter day.
     *
     * @return Response, a redirect to list.
     */
    public function postAddList(Request $request) 
    {
        foreach ($request->input('lists') as $list) {
            DB::table('daylist')->insertGetId(
                array('day' => date('Y-m-d'), 'list' => $list)
            );
        }

        return redirect('shop/list/' . date('Y-m-d'));
    }

    /**
     * Shows list page.
     *
     * @param $id, the id of the list
     * @return Response, a view for showing a specific list page.
     */
    public function getList($date) 
    {
        $res = DB::table('daylist')->where('day', '=', $date)->get();
        $lists = $listIDs = [];
        foreach ($res as $r) {
            $list = ShoppingList::find($r->list);
            $listIDs[] = $r->list;
            $lists[] = $list;
            $list->products()->orderBy('status')->orderBy('name')->get();
        }

        $products = Product::whereIn('list', $listIDs)->orderBy('status')->orderBy('name')->get();


        return view('shop.list')
            ->with('date', $date)
            ->with('lists', $lists)
            ->with('products', $products);
    }
}
