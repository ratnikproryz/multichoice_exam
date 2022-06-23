<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Choice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'id',
        'content',
        'is_answer',
        'question_id',
    ];
    public function choicesubmissions(){
        return $this->hasMany(ChoiceSubmission::class);
    }
}
