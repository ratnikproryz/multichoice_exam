<?php

namespace App\Http\Controllers;

use App\Models\ChoiceSubmission;
use App\Models\Submission;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChoiceSubmissionController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $test_id = $request->input('test_id');
            $submission_id = $request->input('submission_id');
            if ($this->canSubmit($test_id, $submission_id)) {
                $answers = $request->input('answers');
                foreach ($answers as $answer) {
                    $data = [
                        'question_id' => $answer['question_id'],
                        'choice_id' => $answer['choice_id'],
                        'submission_id' => $submission_id
                    ];
                    $submited = ChoiceSubmission::where([
                        'question_id' => $answer['question_id'],
                        'submission_id' => $submission_id
                    ])->first();
                    if ($submited) {
                        //user already submitted the answer then update it
                        $submited->update($data);
                    } else { //store new answer
                        ChoiceSubmission::create($data);
                    }
                }
                DB::commit();
                return response()->json(['message' => "OK!"]);
            }
            return response()->json(['message' => "The test is finished!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return ChoiceSubmission::find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $test_id = $request->input('test_id');
            $submission_id = $request->input('submission_id');
            if ($this->canSubmit($test_id, $submission_id)) {
                $choice_submited = ChoiceSubmission::find($id);
                $choice_submited->update($request->all());
                DB::commit();
                return $choice_submited;
            }
            return response()->json(['message' => "The test is finished!"]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        //
    }

    public static function canSubmit($test_id, $submission_id)
    {
        // return true if user can submit the answers, return false if can't
        $duration = Test::find($test_id)->time;
        $start_time = Submission::find($submission_id)->created_at;
        $current_time = now();
        $deadline = strtotime($start_time . $duration . " minutes");
        $deadline = date("d-m-Y H:i:s", $deadline);
        if ($current_time < $deadline) {
            return true;
        }
        return false;
    }
}
