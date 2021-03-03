@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
    @foreach($poll as $p)
        <div class="col-md-12 p-3">
            <div class="card p-4 h-100 position-relative">
            <form action="{{ route('vote.store', $p->id) }}" method="POST">
            @csrf
                <p class="text-disabled">Deadline : {{ date('d F Y, H:i', strtotime($p->deadline)) }}</p>
                <h3>{{ $p->title }} </h3>
                <p>{{ $p->description }}</p>
                @foreach($p->choice as $c)
                <div class="form-inline my-1">
                    <input type="radio" name="choice_id" id="cc{{ $c->id }}" class="d-inline pt-1" value="{{ $c->id }}">
                    <?php 
                        $vs = DB::table('votes')->where('choice_id', '=', $c->id)->count();
                        $v = DB::table('votes')->groupBy('division_id')->where('choice_id', '=', $c->id)->count();
                        $vc = DB::table('votes')->where('choice_id', '=', $c->id)->groupBy('division_id')->get();
                        
                        $jml = DB::table('votes')->where('choice_id', '=', $c->id)->count();
                        if ($vs === 0) {
                            $jmls = 0;
                        } else { 
                            $ar[$i] = $v;
                            $jmll = $v / $jm * 100 / 100;
                            $ar2[$i] = $jmll;
                            $ss = max($ar);
                            $jm = DB::table('votes')->where('poll_id', '=', $p->id)->count();
                            if ($v === $ss) {
                                $jmls = 1 / $jm * 100 / 100;
                            }
                        } 
                        
                        $done = DB::table('votes')->where('poll_id', '=', $p->id)->where('user_id', '=', $user->id)->count();
                    ?>
                    @if($done < 1 && $p->deadline > date('Y-m-d H:i:s', strtotime(now())))
                    <label class="d-inline ml-2" for="cc{{ $c->id }}">{{ $c->choices }}</label>
                    @else
                    @foreach($vc as $vcc)
                    <label class="d-inline ml-2" for="cc{{ $c->id }}">{{ $c->choices.' (%)' }}</label>
                    @endforeach
                    @endif
                </div>
                <?php $i++ ?>
                @endforeach
                <div class="form-group">
                  <button type="submit" class="btn btn-primary mt-3 px-3" <?php if ($p->deadline < date('Y-m-d H:i:s', strtotime(now())) || $done > 0) {echo 'disabled title="Cant Vote!"';} ?>>Vote</button>
                </div>
            </form>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
