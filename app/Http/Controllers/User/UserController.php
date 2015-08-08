<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use Hash;
use Auth;
use App\PriceCheck;

class UserController extends BaseController
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

    public function getNew() 
    {
        return view('user.new');
    }

    public function postNew(Request $request) 
    {
        $product = new User;
        $product->name = $request->input('name');
        $product->email = $request->input('email');
        $product->password = Hash::make($request->input('password'));
        $product->save();

        return redirect('/')
            ->with('success', 'Användaren har skapats!');
    }

    public function getChangePassword() 
    {
        return view('user.change-password');
    }


    public function postChangePassword(Request $request) 
    {
        if (!($request->input('password') == $request->input('password_confirmation') && strlen($request->input('password')) >= 6)) {
            return redirect()->back()
                ->with('error', 'Lösenordet måste vara minst 6 tecken och stämma överens med det andra lösenordet.');
        }

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->input('old_password')])) {
            return redirect()->back()
                ->with('error', 'Du skrev in fel nuvarande lösenord.');
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect('/')
            ->with('success', 'Lösenordet ändrades!');
    }
}
