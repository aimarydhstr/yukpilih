<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Choice;
use App\Models\User;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'created_by'];

    public function choice(){
        return $this->hasMany(Choice::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
