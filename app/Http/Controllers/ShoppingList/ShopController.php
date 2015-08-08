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
        $this->middleware('auth', ['except' => []]);
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

    public function getSettings($date) 
    {
        $activelists = [];
        foreach(DB::table('daylist')->where('day', '=', $date)->get() as $r) {
            $activelists[] = $r->list;
        }
        return view('shop.settings')
            ->with('date', $date)
            ->with('activelists', $activelists);
    }

    public function postSettings(Request $request) 
    {
        DB::table('daylist')->where('day', '=', $request->input('date'))->delete();
        if ($request->has('lists')) {
            foreach ($request->input('lists') as $list) {
                DB::table('daylist')->insertGetId(
                    array('day' => date('Y-m-d'), 'list' => $list)
                );
            }
        }

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
        if ($product->status == 'done')
            $product->status = NULL;
        else
            $product->status = 'done';
        $product->save();

        return redirect()->back();
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

    public function getAddProduct($date, $stay = false) 
    {
        $res = DB::table('daylist')->join('lists', 'lists.id', '=', 'daylist.list')->where('day', '=', $date)->get();
        foreach ($res as $r) {
            $events[$r->list] = $r->name;
        }

        return view('shop.addproduct')
            ->with('date', $date)
            ->with('stay', $stay)
            ->with('events', $events);
    }

    public function postAddProduct(Request $request) 
    {
        $product = new Product;
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->unitprice = $request->input('unitprice');
        $product->list = $request->input('list');
        $product->moms = $request->input('moms');
        $product->save();

        if ($request->has('stay') && $request->input('stay') == 'yes') {
            return redirect('shop/add-product/' . $request->input('date') . '/stay')
                ->with('success', 'Produkten lades till.');
        }

        return redirect('shop/list/' . $request->input('date'))
            ->with('success', 'Produkten lades till.');
    }
}
