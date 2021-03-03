<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Vote;
use App\Models\Division;
use Auth;

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
        $jml = Vote::groupBy('poll_id')->orderBy('created_at', 'DESC')->count();
        $v = Vote::groupBy('choice_id')->orderBy('created_at', 'DESC')->count();
        $user = Auth::user();
        
        return view('home', compact('poll', 'v', 'jml', 'user', 'div'))->with('i');
    }
}
