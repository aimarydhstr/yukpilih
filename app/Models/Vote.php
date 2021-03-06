<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Choice;
use App\Models\Poll;
use App\Models\Division;
use App\Models\User;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['choice_id', 'user_id', 'poll_id', 'division_id'];

    public function choices(){
        return $this->belongsTo(Choice::class,'choice_id');
    }
    // public function Poll(){
    //     return $this->hasMany(Poll::class);
    // }
    // public function User(){
    //     return $this->hasMany(User::class);
    // }

    public function Division(){
        return $this->belongsTo(Division::class);
    }
}
