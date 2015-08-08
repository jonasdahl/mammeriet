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
        $this->middleware('auth', ['except' => []]);
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
    public function getAddProduct($id, $stay = false) 
    {
        return view('lists.addproduct')
            ->with('stay', $stay)
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
        $product->moms = $request->input('moms');
        $product->list = $list->id;
        $product->save();

        if ($request->has('stay') && $request->input('stay') == 'yes') {
            return redirect('list/add-product/' . $list->id . '/stay')
                ->with('success', 'Produkten lades till.');
        }
        return redirect('list/show/' . $list->id)
            ->with('success', 'Produkten lades till.');
    }

    public function getEditProduct($id, $back = 'list') 
    {
        $res = ShoppingList::orderBy('eventdate')->get();
        foreach ($res as $r) {
            $events[$r->id] = $r->name . ' (' . date("Y-m-d", strtotime($r->eventdate)) . ')';
        }

        $product = Product::find($id);
        return view('lists.editproduct')
            ->with('events', $events)
            ->with('product', $product)
            ->with('back', $back)
            ->with('list', $product->shoppingList);
    }

    public function postEditProduct(Request $request) 
    {
        $product = Product::find($request->input('id'));
        $product->name = $request->input('name');
        $product->moms = $request->input('moms');
        $product->quantity = $request->input('quantity');
        $product->unitprice = $request->input('unitprice');
        $product->list = $request->input('list');
        $product->save();

        if ($request->input('back') == 'list') {
            return redirect('list/show/' . $product->list)
                ->with('success', 'Produkten ändrades.');
        } else {
            return redirect('shop/list/' . date("Y-m-d"))
                ->with('success', 'Produkten ändrades.');
        }
    }

    public function getNew() 
    {
        return view('lists.new');
    }

    public function postNew(Request $request) 
    {
        $list = new ShoppingList;
        $list->name = $request->input('name');
        $list->eventdate = $request->input('eventdate');
        $list->budget = $request->input('budget');
        $list->save();

        return redirect('list/show/' . $list->id)
            ->with('success', 'Inköpslistan skapades!');
    }

    public function getDeleteProduct($id) 
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->back();
    }

    public function getSettings($id) 
    {
        $list = ShoppingList::find($id);

        return view('lists.settings')
            ->with('list', $list);
    }

    public function postSettings(Request $request) 
    {
        $list = ShoppingList::find($request->input('id'));
        $list->budget = $request->input('budget');
        $list->name = $request->input('name');
        $list->eventdate = $request->input('eventdate');
        $list->save();

        return redirect('list/show/' . $list->id)
            ->with('success', 'Listan uppdaterades.');
    }
}
