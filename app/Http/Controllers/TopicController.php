<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function index()
    {
        return Topic::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $image= ImageController::store($request);
            $topic = Topic::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'image' => $image,
            ]);
            DB::commit();
            return response()->json($topic);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return Topic::find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $topic = Topic::find($id);
        $image = ImageController::store($request);
        $topic->update($request->all());
        $topic->update(['image'=>$image]);
        return response()->json($topic);
    }

    public function destroy($id)
    {
        Topic::find($id)->delete();
        return response()->json(['message' => 'Delete topic successfully!'], 200);
    }
}
