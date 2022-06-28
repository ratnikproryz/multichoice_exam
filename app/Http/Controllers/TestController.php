<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return Test::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            $test = Test::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'time' => $request->input('time'),
                'total_point' => $request->input('total_point'),
                'topic_id' => $request->input('topic_id'),
                'user_id' => $user->id,
            ]);
            DB::commit();
            return response()->json($test);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $test = Test::find($id);
        $questions = $test->questions;
        foreach ($questions as $question) {
            $question->choices;
        }
        return $test;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        $test->update($request->all());
        return $test;
    }

    public function destroy($id)
    {
        Test::find($id)->delete();
        return response()->json(['message' => "Delete test successfully!"]);
    }
}
