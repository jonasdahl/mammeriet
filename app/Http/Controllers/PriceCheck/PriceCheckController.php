<?php

namespace App\Http\Controllers\PriceCheck;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\PriceCheck;

class PriceCheckController extends BaseController
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
     * Shows create new pricecheck form.
     *
     * @return Response, a view for showing the form.
     */
    public function getNew() 
    {
        return view('pricecheck.new');
    }

    /**
     * Shows create new pricecheck form.
     *
     * @return Response, a view for showing the form.
     */
    public function postNew(Request $request) 
    {
        $product = new Product;
        $product->name = $request->input('name');
        $product->save();
        $pricecheck = new PriceCheck;
        $pricecheck->product = $product->id;
        $pricecheck->save();

        return redirect('/')
            ->with('success', 'Mammeriet kommer nu kolla priset på denna vara!');
    }

    /**
     * Shows list page.
     *
     * @return Response, a view for showing the list of pricechecks.
     */
    public function getAll() 
    {
        return view('pricecheck.list');
    }

    /**
     * Set the price.
     *
     * @return Response, a view for setting the price.
     */
    public function getSetPrice($id) 
    {
        return view('pricecheck.setprice')
            ->with('pricecheck', PriceCheck::find($id));
    }

    /**
     * Set the price.
     *
     * @return Response, a view for setting the price.
     */
    public function postSetPrice(Request $request) 
    {
        /* TODO: Skicka mejl med pris till rätt person. */
        $pricecheck = PriceCheck::find($request->input('id'));
        $pricecheck->unitprice = $request->input('price');
        $pricecheck->save();

        return redirect('pricecheck/all')
            ->with('success', 'Priset på ' . $pricecheck->productInfo->name . ' sattes till ' . $pricecheck->unitprice . ' kr.');
    }
}
