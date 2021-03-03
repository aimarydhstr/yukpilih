@extends('layouts.app') 
@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 mt-1 p-0">Edit Poll</h5></div>
                <div class="card-body"> 
                    <form action="{{ route('poll.update', $poll->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if (session('status'))
                        <div class="alert alert-danger my-3">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" name="title" value="{{ $poll->title }}">    
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="5">{{ $poll->description }}</textarea> 
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <div class="row justify-content-between">
                                <input type="date" id="deadline" class="col-5 form-control ml-3" name="deadline1" value="{{ date('Y-m-d', strtotime($poll->deadline)) }}">
                                <input type="time" id="deadline" class="col-5 form-control mr-3" name="deadline2" value="{{ date('H:i', strtotime($poll->deadline)) }}">
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label for="choices1">Choice 1</label>
                            <input onkeyup="nambah(1)" type="text" id="choices1" class="form-control" name="choices1" value="{{ $ch->choices }}">    
                        </div>

                        @foreach($choice as $c)
                        <?php $i = ++$i; ?>
                        <div class='form-group <?php if ($i === 1) {echo "d-none";} ?>' id="c{{ $i }}">
                            <label for="choices{{ $i }}">Choice {{ $i }}</label>
                            <div class='row p-0 m-0 justify-content-between'>
                                <input onkeyup="nambah({{ $i }})" <?php if ($i === 1) {echo "disabled";} ?> type="text" id="choices{{ $i }}" class="form-control col-10" name="choices{{ $i }}" value="{{ $c->choices }}">
                                <a href="{{ route('poll.del', $c->id) }}" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                        @endforeach

                    @for($a=1;$a<=4;$a++)
                        <div id="gas{{ $a }}"></div>
                    @endfor

                        <script>
                        for(var a=1;a<=4;a++){
                            function nambah(a) {
                                var b = a+1;
                                var x = document.getElementById("choices"+a).value;
                                var y = "<div class='form-group'><label for='choices"+b+"'>Choice "+b+"</label><div class='row p-0 m-0 justify-content-between'><input onchange='nambah("+b+")' type='text' id='choices"+b+"' class='form-control col-10' name='choices"+b+"'><button type='button' onclick='ngurang("+b+")' class='btn btn-danger d-inline'>Delete</button></div></div>";
                                var v = document.getElementById("choices"+b);
                         
                                if(x !== ""){
                                    if (!v) {
                                        document.getElementById("gas"+a).innerHTML = y;
                                    } else {
                                        document.getElementById("c"+b).style.display = 'block';
                                    }
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
