<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function change()
    {
        return view('auth.change');
    }
         
    public function changePassword(Request $request)
    {   
        if (!(Hash::check($request->password1, Auth::user()->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
            
        else if($request->password1 === $request->password2){
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        else if($request->password2 !== $request->password3){
            return redirect()->back()->with("error","New Password should be same as your confirmed password. Please retype new password.");
        }
        else {
        $user = Auth::user();
        $user->password = bcrypt($request->input('password2'));
        $user->save();

        Auth::logout();
        
        return redirect()->route('login')->with("success","Password changed successfully !");
        }
    }
}
