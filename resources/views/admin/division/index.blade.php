@extends('layouts.app') 
@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-left m-0 mt-1 p-0">Division Management</h5> 
                    <a href="{{ route('division.create') }}" class="btn btn-primary float-right btn-sm">New Division</a></div>
                <div class="card-body"> 
                
                    @if (session('status'))
                        <div class="alert alert-success mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach($div as $d)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $d->name }}</td>
                                <td>
                                    <a href="{{ route('division.edit', $d->id) }}" class="btn btn-primary btn-sm mr-1">Edit</a>
                                    <form action="{{ route('division.delete', $d->id) }}" method="POST" class="d-inline">
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
