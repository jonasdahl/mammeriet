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
}
