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
        $this->middleware('auth', ['except' => ['getNew', 'postNew']]);
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
        $product->description = $request->input('description');
        $product->save();
        $pricecheck = new PriceCheck;
        $pricecheck->product = $product->id;
        $pricecheck->responsibleperson = $request->input('responsibleperson');
        $pricecheck->responsiblepersonemail = $request->input('responsiblepersonemail');
        $pricecheck->save();

        return redirect('pricecheck/new')
            ->with('success', 'Du får ett mejl till ' . $request->input('responsiblepersonemail') . ' när vi checkat vad det kostar. Skriv in en ny vara om du vill!');
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
        $pricecheck = PriceCheck::find($request->input('id'));
        if ($request->input('moms') == 'yes') {
            $pricecheck->unitprice = $request->input('price');
        } else {
            $pricecheck->unitprice = $request->input('price') * ($request->input('momssats') / 100 + 1);
        }
        $pricecheck->unit = $request->input('unit');
        $pricecheck->save();

        $name = $pricecheck->productInfo->name;

        \Mail::send('emails.pricechecked', ['pricecheck' => $pricecheck], function($message) use ($pricecheck) {
            $message->to($pricecheck->responsiblepersonemail, $pricecheck->responsibleperson)->subject('Mammeriet har kollat pris på en sak!');
        });

        return redirect('pricecheck/all')
            ->with('success', 'Priset på ' . $pricecheck->productInfo->name . ' sattes till ' . $pricecheck->unitprice . ' kr och ett mejl skickades till ' . $pricecheck->responsiblepersonemail . '.');
    }
}
