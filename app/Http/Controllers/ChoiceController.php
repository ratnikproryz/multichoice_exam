<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store($choice, $question_id)
    {
        return  Choice::create([
            'content' => $choice["content"],
            'is_answer' => $choice["is_answer"],
            'question_id' => $question_id,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
