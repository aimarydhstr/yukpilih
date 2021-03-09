@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
    @foreach($polls as $p)
        <div class="col-md-12 p-3">
            <div class="card p-4 h-100 position-relative">
            <form action="{{ route('vote.store', $p->id) }}" method="POST">
            @csrf
                <p>Deadline : {{ date('d F Y, H:i', strtotime($p->deadline)) }}</p>
                <h3>{{ $p->title }} </h3>
                <p>{{ $p->description }}</p>
                @php
                    $done = DB::table('votes')->where('poll_id', '=', $p->id)->where('user_id', '=', $user->id)->count();
                @endphp
                @foreach($p->choice as $c)
                <div class="form-inline my-1">
                    <input type="radio" name="choice_id" id="cc{{ $c->id }}" class="d-inline pt-1" value="{{ $c->id }}">
                    <?php 
                        // $vs = DB::table('votes')->where('choice_id', '=', $c->id)->count();
                        // $v = DB::table('votes')->groupBy('division_id')->where('choice_id', '=', $c->id)->count();
                        // $i = 0;
                        // foreach($div as $d){
                        //     $sc = DB::table('votes')->where('division_id', '=', $d->id)->count();
                        //     $vc = DB::table('votes')->where('division_id', '=', $d->id)->where('choice_id', '=', $c->id)->count();
                        //     $vc1[$i++] = $vc;
                        //     $vc2 = max($vc1);
                        //     if ($vc >= $sc) {
                        //         $vc = 1;
                        //     } else {
                        //         $vc = 0;
                        //     }
                        // }
                        
                        // $jml = DB::table('votes')->where('choice_id', '=', $c->id)->count();
                        // if ($vs === 0) {
                        //     $jmls = 0;
                        // } else { 
                        //     $ar[$i] = $v;
                        //     $jm = DB::table('votes')->where('poll_id', '=', $p->id)->count();
                        //     $jmll = $v / $jm * 100 / 100;
                        //     $ar2[$i] = $jmll;
                        //     $ss = max($ar);
                        //     if ($v === $ss) {
                        //         $jmls = $v / $jm * 100 / 100;
                        //     }
                        // } 
                        
                        // $done = DB::table('votes')->where('poll_id', '=', $p->id)->where('user_id', '=', $user->id)->count();
                    ?>
                    @if($done < 1 && $p->deadline > date('Y-m-d H:i:s', strtotime(now())))
                    <label class="d-inline ml-2" for="cc{{ $c->id }}">{{ $c->choices }}</label>
                    @else
                    <label class="d-inline ml-2" for="cc{{ $c->id }}">{{ $c->choices.' ('.($c->poin ?? 0).'%)' }}</label>
                    {{-- @foreach($vc1 as $vcc)
                    <label class="d-block w-100 my-2" for="cc{{ $c->id }}">{{ $c->choices.' (0%)' }}</label>
                    @endforeach --}}
                    @endif
                </div>
                <?php //$i++ ?>
                @endforeach
                <div class="form-group">
                  <button type="submit" class="btn btn-primary mt-3 px-3" <?php if ($p->deadline < date('Y-m-d H:i:s', strtotime(now())) || $done > 0 || $user->role === 'admin') {echo 'disabled title="Cant Vote!"';} ?>>Vote</button>
                </div>
            </form>
            </div>
        </div>
    @endforeach
    </div>
    {{-- <a href="{{ route('poll.create', $polls) }}" title="Create Poll" class="btn btn-success shadow p-0 fixed-bottom rounded-circle btns">+</a> --}}
</div>

<style>
.btns {
    width:50px;
    height:50px;
    font-size:30px;
    bottom:20px;
    right:20px;
    left:unset;
}
</style>

@endsection
