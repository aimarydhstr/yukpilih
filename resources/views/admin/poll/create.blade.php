@extends('layouts.app') 
@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 mt-1 p-0">New Poll</h5></div>
                <div class="card-body"> 
                    <form action="{{ route('poll.store', $id) }}" method="POST">
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-danger my-3">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" name="title">    
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="5"></textarea> 
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <div class="row justify-content-between">
                                <input type="date" id="deadline" class="col-5 form-control ml-3" name="deadline1">
                                <input type="time" id="deadline" class="col-5 form-control mr-3" name="deadline2">
                            </div>    
                        </div>

                        <div class="form-group">
                            <label for="choices1">Choice 1</label>
                                <input onchange="nambah(1)" type="text" id="choices1" class="form-control" name="choices1">
                        </div>

                    @for($a=1;$a<=4;$a++)
                        <div id="gas{{ $a }}"></div>
                    @endfor

                        <script>
                        for(var a=1;a<=5;a++){
                            function nambah(a) {
                                var b = a+1;
                                var x = document.getElementById("choices"+a).value;
                                var y = "<div class='form-group'><label for='choices"+b+"'>Choice "+b+"</label><div class='row p-0 m-0 justify-content-between'><input onchange='nambah("+b+")' type='text' id='choices"+b+"' class='form-control col-10' name='choices"+b+"'><button type='button' onclick='ngurang("+b+")' class='btn btn-danger d-inline'>Delete</button></div></div>";
                                
                                if(x !== ""){
                                    document.getElementById("gas"+a).innerHTML = y;
                                } else {
                                    document.getElementById("gas"+a).innerHTML = x;
                                }
                            }
                            function ngurang(a) {
                                var b = a - 1;
                                var x = document.getElementById("choices"+a).value;
                         
                                if(x !== ""){
                                    document.getElementById("gas"+b).innerHTML = '';
                                } else {
                                    document.getElementById("gas"+b).innerHTML = '';
                                }
                            }
                        }
                        </script>
                        
                        <div class="form-group mt-3">
                            <a href="{{ route('poll') }}" class="btn btn-secondary mr-1">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
