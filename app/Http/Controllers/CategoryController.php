<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $category = Category::create(['name' => $request->input('name')]);
        return response()->json($category);
    }

    public function show($id)
    {
        return Category::find($id);
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $category =Category::find($id);
        $category->update($request->all());
        return $category;
    }

    public function destroy($id)
    {
        Category::find($id)->delete(); //softDeletes
        return response()->json(['message'=> 'Delete category successfully!'], 200);
    }
}
