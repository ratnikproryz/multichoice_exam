<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Submission;
use App\Models\ChoiceSubmission;
use App\Models\Test;

class SubmissionController extends Controller
{
    public function index()
    {
        $test = Test::select('id', 'total_point', 'user_id')->find(3);
        return $test->questions->count();
        $answer = Choice::select('id', 'is_answer', 'question_id')
            ->where([
                'question_id' => '3',
                'is_answer' => 1
            ])->first();
        return $answer->id;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $submission = Submission::create([
            'test_id' => $request->input('test_id'),
            'user_id' => $user->id,
        ]);
        return response()->json($submission);
    }

    public function show($id)
    {
        return response()->json(Submission::find($id));
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

    public function calcPoint(Request $request)
    {
        $submission_id = $request->input('submission_id');
        $submission = Submission::find($submission_id);
        $answers = ChoiceSubmission::where('submission_id',$submission_id)->get();
        $test = Test::select('id', 'total_point', 'user_id')->find($submission->test_id);
        $total_point = $test->total_point;
        $total_questions = $test->questions->count();
        $num_correct_answers = 0;

        try {
            DB::beginTransaction();
            foreach ($answers as $answer) {
                $correct_choice = Choice::select('id', 'is_answer')
                    ->where([
                        'question_id' => $answer['question_id'],
                        'is_answer' => 1,
                    ])->first();
                if ($answer['choice_id'] == $correct_choice->id) {
                    $num_correct_answers++;
                }
            }
            $point = $num_correct_answers * $total_point / $total_questions;
            $submission->update(['point' => $point]);
            DB::commit();
            return $point;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
