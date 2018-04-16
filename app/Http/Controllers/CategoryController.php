<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = app('auth')->guard()->user();

        return response()->json($user->categories);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $user = app('auth')->guard()->user();

        if ($request->has('name')) {
            $category = new Category;
            $category->name = $request->input('name');
            $category->user_id = $user->id;
            $category->save();

            return response()->json($category, 201);
        } else {
            return response()->json(['status' => 'Body error'], 400);
        }
    }

    public function update($id, Request $request)
    {
        $user = app('auth')->guard()->user();
        $category = Category::findOrFail($id);

        if ($category->user_id == $user->id) {
            $category->update($request->all());

            return response()->json($category, 200);
        } else {
            return response()->json(['status' => 'HOW CAN YOU SLAP'], 401);
        }
    }

    public function delete($id)
    {
        $user = app('auth')->guard()->user();
        $category = Category::findOrFail($id);

        if ($category->user_id == $user->id) {
            $category->delete();

            return response()->json(['status' => 'Deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'HOW CAN YOU SLAP'], 401);
        }
    }
}
