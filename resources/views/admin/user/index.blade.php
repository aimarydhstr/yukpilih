@extends('layouts.app') 
@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-left m-0 mt-1 p-0">User Management</h5> 
                    <a href="{{ route('user.create') }}" class="btn btn-primary float-right btn-sm">New User</a></div>
                <div class="card-body"> 
                
                    @if (session('status'))
                        <div class="alert alert-success mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <tr class="text-center">
                                <th class="text-left">#</th>
                                <th class="text-left">Name</th>
                                <th>Division</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            @foreach($user as $u)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $u->name }}</td>
                                <td class="text-center">{{ $u->division->name }}</td>
                                <td class="text-capitalize text-center">{{ $u->role }}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.edit', $u->id) }}" class="btn btn-primary btn-sm mr-1">Edit</a>
                                    <form action="{{ route('user.delete', $u->id) }}" method="POST" class="d-inline">
                                    @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
