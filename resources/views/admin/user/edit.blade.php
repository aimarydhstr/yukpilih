@extends('layouts.app') 
@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 mt-1 p-0">Edit User</h5></div>
                <div class="card-body"> 
                    <form action="{{ route('user.update', $u->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if (session('status'))
                        <div class="alert alert-danger my-3">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ $u->name }}">    
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{ $u->email }}">    
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" class="form-control" name="password">    
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="" selected disabled>Choose role</option>
                                <option <?php if($u->role === 'admin'){echo 'selected';} ?> value="admin">Admin</option>
                                <option <?php if($u->role === 'user'){echo 'selected';} ?> value="user">User</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="division_id">Division</label>
                            <select name="division_id" id="division_id" class="form-control">
                                <option value="" selected disabled>Choose Division</option>
                                @foreach($div as $d)
                                <option <?php if($u->division_id === $d->id){echo 'selected';} ?> value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mt-3">
                            <a href="{{ route('user') }}" class="btn btn-secondary mr-1">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
