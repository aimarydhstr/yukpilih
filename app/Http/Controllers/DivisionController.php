<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $div = Division::all();
        return view('admin.division.index',compact('div'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.division.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status', 'Create Failed!');
        }

        $crud = Division::create([
            'name' => $request->name
        ]);

        if ($crud) {
            return redirect()->route('division')->with('status', 'Division Created!');
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
        $div = Division::findOrFail($id);
        return view('admin.division.edit',compact('div'))->with('i');
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
        $div = Division::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status', 'Update Failed!');
        }

        $crud = $div->update([
            'name' => $request->name
        ]);

        if ($crud) {
            return redirect()->route('division')->with('status', 'Division Updated!');
        } else {
            return redirect()->back()->withInput()->with('status', 'Update Failed!');
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
        $div = Division::findOrFail($id);

        $crud = $div->delete();

        if ($crud) {
            return redirect()->route('division')->with('status', 'Division Deleted!');
        } else {
            return redirect()->back()->withInput()->with('status', 'Delete Failed!');
        }
    }
}
