<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'title',
        'description',
        'time',
        'total_point',
        'topic_id',
        'user_id',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function submissions(){
        return $this->hasMany(Submission::class);
    }
    public function choices(){
        return $this->hasManyThrough(Choice::class, Question::class);
    }
}
