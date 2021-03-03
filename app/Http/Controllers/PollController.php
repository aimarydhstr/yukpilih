<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Choice;
use Validator;
use Auth;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poll = Poll::all();
        $polls = Poll::orderBy('created_at', 'DESC')->first();
        $polls = $polls->id + 1;
        return view('admin.poll.index',compact('poll', 'polls'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $id = $id;
        return view('admin.poll.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'deadline1' => ['required'],
            'deadline2' => ['required'],
            'choices1' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status', 'Create Failed!');
        }

        
        $crud = Poll::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline1.' '.$request->deadline2,
            'created_by' => Auth::user()->id
        ]);
        
        if ($crud) {
            $poll_id = Poll::findOrFail($id);
            for ($a=1; $a <= 5; $a++) { 
                if ($request->input('choices'.$a)) {
                    $crud2 = Choice::create([
                        'choices' => $request->input('choices'.$a),
                        'poll_id' => $poll_id->id
                    ]);
                } else {}
            }
            return redirect()->route('poll')->with('status', 'Poll Created!');
            if ($crud2) {
                return redirect()->route('poll')->with('status', 'Poll Created!');
            } else {
                return redirect()->back()->withInput()->with('status', 'Create Failed!');
            }
        } else {
            return redirect()->back()->withInput()->with('status', 'Create Failed!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll = Poll::findOrFail($id);
        $ch = Choice::where('poll_id', '=', $id)->first();
        $choice = Choice::where('poll_id', '=', $id)->get();
        $count = Choice::where('poll_id', '=', $id)->count();
        return view('admin.poll.edit',compact('poll', 'choice', 'count', 'ch'))->with('i');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {      
        $div = Poll::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'deadline1' => ['required'],
            'deadline2' => ['required'],
            'choices1' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->route('poll')->withInput()->with('status', 'Update Failed!');
        }

        $crud = $div->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline1.' '.$request->deadline2
        ]);

        if ($crud) {
            $choice = Choice::where('poll_id', '=', $id)->get();
            $count = Choice::where('poll_id', '=', $id)->count();
            $a = 1;
            foreach ($choice as $c) {
                $b = $c->id;
                $z = $a++;
                $cccc = Choice::findOrFail($b);
                $crud2 = $cccc->update([
                    'choices' => $request->input('choices'.$z),
                    'poll_id' => $id
                ]);
            }
            $ccccccc = $count + 1;
            if ($request->input('choices'.$ccccccc)) {
                $crud3 = Choice::create([
                    'choices' => $request->input('choices'.$ccccccc),
                    'poll_id' => $id
                ]);
            } else{}
            return redirect()->route('poll')->with('status', 'Poll Updated!');
        } else {
            return redirect()->back()->with('status', 'Update Failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $div = Poll::findOrFail($id);

        $crud = $div->delete();

        if ($crud) {
            return redirect()->route('poll')->with('status', 'Poll Deleted!');
        } else {
            return redirect()->back()->withInput()->with('status', 'Delete Failed!');
        }
    }
    
    public function del($id)
    {
        $c = Choice::findOrFail($id);

        $crud = $c->delete();

        if ($crud) {
            return redirect()->back()->withInput();
        } else {
            return redirect()->back()->withInput();
        }
    }
}
