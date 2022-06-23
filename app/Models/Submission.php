<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'id', 
        'point', 
        'test_id', 
        'user_id', 
    ];
    public function choicesubmissions(){
        return $this->hasMany(ChoiceSubmission::class);
    }
}
