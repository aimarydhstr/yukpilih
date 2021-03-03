<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Choice;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'created_by'];

    public function choice(){
        return $this->hasMany(Choice::class);
    }
}
