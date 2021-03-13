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
        $polls = Poll::with(['choice', 'choice.votes', 'choice.votes.division'])->get();
        // dd($polls->toArray());
        // $votes = Vote::with(['division']);
        $choices = $this->countTotalPoinDivison();
        $total_choices = array_sum(array_column($choices, "total_poin"));
        // dd($total_choices);
        foreach ($polls as $index => $item) {
            foreach ($item->choice as $index_c => $item_c) {
                foreach ($choices as $index_co => $item_co) {
                    if ($index_co == $item_c['id']) {
                        $polls[$index]->choice[$index_c]->poin = $item_co['total_poin'] / $total_choices * 100;
                    }
                }
            }
        }


        $user = Auth::user();
        return view('home', compact("polls", "user"));
    }


    private function countTotalPoinDivison()
    {
        $division = Division::with('votes')->get();
        $division_poin = [];
        foreach ($division as $index => $item) {
            $division_choice = [];
            // dd($item->votes->toArray());
            foreach ($item->votes as $index_v => $item_v) {
                $poin = 0;
                // dd($item_v);
                // count()
                if (!in_array($item_v->choice_id, array_column($division_choice, "choice_id"))) {
                    $poin += 1;
                    $division_choice[] = ["choice_id" => $item_v->choice_id, "poll_id" => $item_v->poll_id, "division_id" => $item_v->division_id, "poin" => $poin];
                } else {
                    $index = array_search($item_v->choice_id, array_column($division_choice, "choice_id"));
                    $poin = $division_choice[$index]['poin'] + 1;
                    $division_choice[$index] = ["choice_id" => $item_v->choice_id, "poll_id" => $item_v->poll_id, "division_id" => $item_v->division_id, "poin" => $poin];
                }
                // dd($division_choice);
                // echo json_encode($division_choice);
            }
            // die();
            // dd($division_choice);
            if (count($division_choice) >= 1) {
                // dd(array_keys(array_column($division_choice, 'poin'), max(array_column($division_choice, 'poin'))));
                $highest_index = array_keys(array_column($division_choice, 'poin'), max(array_column($division_choice, 'poin')));
                // dd($highest_index);
            }
            if (!empty($division_choice)) {
                $highest_division_choice = [];
                $poin = 0;
                foreach ($division_choice as $index_c => $item_c) {
                    // dd($item_c);
                    if ($index_c == $highest_index[0]) {
                        if ($item_c['poin'] > $poin) {
                            $poin = $item_c['poin'];
                            $highest_division_choice[] = ["poll_id" => $item_c['poll_id'], "choice_id" => $item_c['choice_id'], "poin" => $item_c['poin'] / count($division_choice)];
                        } else if ($item_c['poin'] == $poin) {
                            $poin = $item_c['poin'];
                            $highest_division_choice[] = ["poll_id" => $item_c['poll_id'], "choice_id" => $item_c['choice_id'], "poin" => $item_c['poin'] / count($division_choice)];
                        }
                    }
                }
                $division_choice = $highest_division_choice;
            }
            $division_poin[] = [
                "divison_name" => $item->name,
                "division_id" => $item->id,
                "divison_choice" => $division_choice
            ];

            // dd($division_poin);
        }
        $choices = [];
        foreach ($division_poin as $index_p => $item_p) {
            // dd($item_p);
            if (!empty($item_p['divison_choice'])) {
                foreach ($item_p['divison_choice'] as $index_c => $item_c) {
                    $total_poin = 0;
                    if (!isset($choices[$item_c['choice_id']])) {
                        $total_poin += $item_c['poin'];
                        $choices[$item_c['choice_id']] = [
                            "poll_id" => $item_c['poll_id'],
                            "choice_id" => $item_c['choice_id'],
                            "total_poin" => $total_poin,
                        ];
                    } else {
                        // $index = array_search($item_v->choice_id, array_column($choices, "choice_id"));
                        $total_poin = $choices[$item_c['choice_id']]['total_poin'] + $item_c['poin'];
                        $choices[$item_c['choice_id']]['total_poin'] = $total_poin;
                    }
                }
            }
        }
        // die();
        // dd($choices);
        // dd($division_poin);
        // dd($division_choice);
        // dd($division->toArray());
        // dd($polls->toArray());
        return $choices;
    }
}
