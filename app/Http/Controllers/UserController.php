<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('division')->orderBy('division_id', 'ASC')->orderBy('division_id', 'ASC')->get();
        return view('admin.user.index',compact('user'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $div = Division::orderBy('name', 'ASC')->get();
       return view('admin.user.create',compact('div'));
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
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required'],
            'role' => ['required'],
            'division_id' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status', 'Create Failed!');
        }

        $crud = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
            'division_id' => $request->division_id
        ]);

        if ($crud) {
            return redirect()->route('user')->with('status', 'User Created!');
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
        $u = User::findOrFail($id);
        $div = Division::orderBy('name', 'ASC')->get();
        return view('admin.user.edit',compact('u','div'))->with('i');
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
        $user = User::findOrFail($id);
        $password = $user->password;

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'role' => ['required'],
            'division_id' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status', 'Update Failed!');
        }

        if ($request->password === "") {
            $crud = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'role' => $request->role,
                'division_id' => $request->division_id
            ]);
        } else{
            $crud = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'role' => $request->role,
                'division_id' => $request->division_id
            ]);
        }

        if ($crud) {
            return redirect()->route('user')->with('status', 'User Updated!');
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
        $user = User::findOrFail($id);

        $crud = $user->delete();

        if ($crud) {
            return redirect()->route('user')->with('status', 'User Deleted!');
        } else {
            return redirect()->back()->withInput()->with('status', 'Delete Failed!');
        }
    }
}
