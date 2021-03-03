<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Vote;
use App\Models\Division;
use Auth;
use Hash;

class HomeController extends Controller
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
    public function index()
    {
        $poll = Poll::with('choice')->get();
        $div = Division::all();
        $user = Auth::user();
        
        $polls = Poll::orderBy('created_at', 'DESC')->first();
        $polls = $polls->id + 1;
        
        if(Hash::check('password', Auth::user()->password)) {
            return redirect()->route('change')->with('success', 'You must change your old password! Old password : password');
        } else {
            return view('home', compact('poll', 'user', 'div', 'polls'))->with('i');
        }
    }

}
