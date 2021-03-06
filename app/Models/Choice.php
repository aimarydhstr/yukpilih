<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poll;
use App\Models\Vote;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = ['choices', 'poll_id'];

    public function poll(){
        return $this->belongsTo(Poll::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

}
