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
        // $poll = Poll::with('choice')->get();
        // $div = Division::all();
        // $user = Auth::user();

        // $polls = Poll::orderBy('created_at', 'DESC')->first();
        // $polls = $polls->id + 1;

        // if(Hash::check('password', Auth::user()->password)) {
        //     return redirect()->route('change')->with('success', 'You must change your old password! Old password : password');
        // } else {
        //     return view('home', compact('poll', 'user', 'div', 'polls'))->with('i');
        // }
        $hasil_vote = [];
        $votes = Poll::with(['choice', 'choice.votes', 'choice.votes.division'])->get();
        $divisions = Division::with(['votes', 'votes.choices'])->get();
        $total_poin = 0;
        foreach ($divisions as $index => $item) {
            // $hasil_vote[$item->name] = [
            //     "division_name" => $item->name,
            // ]
            if ($item->votes) {
                foreach ($item->votes as $index_v => $item_v) {
                    // $hasil_vote[] = ["division_name" => $item->name,"choices" => $item_v->choices->toArray()];
                    if (!in_array($item->name, array_column($hasil_vote,'division_name'))) {
                        // $a[] = $value;
                        $hasil_vote[$item->name] = ["division_name"=>$item->name,"choices"=>[$item_v->choices->toArray()]];
                    }else{
                        array_push($hasil_vote[$item->name]['choices'],$item_v->choices->toArray());
                    }
                }
            }

            // if($item->votes->choices[0]){
            //     $hasil_vote[] = [
            //         "division_name" => $item->name,
            //         "choice_name" => $item->votes->choices[0]->choices
            //     ];
            // }

        }


        dd($hasil_vote);
        dd($divisions->toArray());
        $total_vote = Vote::count();
        foreach ($votes as $index => $item) {
            foreach ($item->choice as $index_c => $item_c) {
                foreach ($item_c->votes as $index_v => $item_v) {
                }
                // dd(count($item_c->votes->toArray()));
                // $votess = $item_c->votes->toArray();
                // foreach($divisions as $index_d => $item_d){

                // }

                // foreach($item_)
                // if(!empty($votess))
                // $total_vote = $item->votes->toArray();
                // if(!empty($votess)){
                //     $hasil_vote[] = [
                //         "choice_id" => $item_c->id,
                //         "choice_name" => $item_c->choices,
                //         "total_votes" => count($item_c->votes) / $total_vote * 100
                //     ];
                // }else{
                //     $hasil_vote[] = [
                //         "choice_id" => $item_c->id,
                //         "choice_name" => $item_c->choices,
                //         "total_votes" => 0
                //     ];
                // }

                // foreach($item_c->votes as $index_v => $item_v){

                // }
            }
        }
        // dd($hasil_vote);
        dd($votes->toArray());
    }
}
