<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChoiceSubmission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'choice_id',
        'submission_id',
        'question_id',
    ];
}
