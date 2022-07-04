<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request) //store all questions of a test
    {
        try {
            DB::beginTransaction();
            $test_id = $request->input('test_id');
            $questions = $request->input('questions');

            $response = array();
            foreach ($questions as $question) {
                // store new question
                $questions_res = [
                    "question" => [],
                    'choices' => []
                ];
                $new_question = Question::create([
                    'content' => $question["content"],
                    'test_id' => $test_id,
                ]);
                array_push($questions_res['question'], $new_question);
                // store new choices of new question`
                $choices = $question["choices"];
                foreach ($choices as $choice) {
                    $new_choice = new ChoiceController();
                    $new_choice = $new_choice->store($choice, $new_question->id);
                    array_push($questions_res['choices'], $new_choice);
                }

                array_push($response, $questions_res);
            }
            DB::commit();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $question = Question::find($id);
        $question->choices;
        return $question;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $test = Test::find($question->test_id);
        $this->authorize('manage', [$question, $test]);
        try {
            DB::beginTransaction();
            $question->update($request->all());
            $choices = $request->input('choices');
            if ($choices) {
                foreach ($choices as $item) {
                    $choice = Choice::find($item["id"]);
                    $choice->update([
                        'content' => $item["content"],
                        'is_answer' => $item["is_answer"],
                    ]);
                }
            }
            DB::commit();
            $question->choices;
            return $question;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        Question::find($id)->delete();
        return response()->json(['message' => "Delete question successfully!"]);
    }
}
