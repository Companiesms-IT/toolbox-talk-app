<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    public function options() {
       return $this->hasMany(Option::class, 'question_id', 'id');
    }
    
    public function correctAnswer() {
       return $this->hasMany(Option::class, 'question_id', 'id')->where('correct_answer', '1');
    }
}
