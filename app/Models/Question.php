<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'id',
        'content',
        'test_id',
    ];

    public function choices(){
        return $this->hasMany(Choice::class);
    }
}
