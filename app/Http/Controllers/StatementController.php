<?php

namespace App\Http\Controllers;

use App\Statement;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = app('auth')->guard()->user();

        return response()->json($user->statements()->with('account', 'category')->get());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'account_id' => 'required',
            'amount' => 'required',
            'notes' => 'required',
            'category_id' => 'required',
            'isLoan' => 'required',
        ]);

        $user = app('auth')->guard()->user();

        if ($request->has('account_id') && $request->has('category_id')) {
            $statement = new Statement;
            $statement->date = $request->input('date');
            $statement->account_id = $request->input('account_id');
            $statement->amount = $request->input('amount');
            $statement->notes = $request->input('notes');
            $statement->category_id = $request->input('category_id');
            $statement->isLoan = $request->input('isLoan');
            $statement->user_id = $user->id;
            $statement->save();

            return response()->json($statement, 201);
        } else {
            return response()->json(['status' => 'Body error'], 400);
        }
    }

    public function update($id, Request $request)
    {
        $user = app('auth')->guard()->user();
        $statement = Statement::findOrFail($id);

        if ($statement->user_id == $user->id) {
            $statement->update($request->all());

            return response()->json($statement, 200);
        } else {
            return response()->json(['status' => 'HOW CAN YOU SLAP'], 401);
        }
    }

    public function delete($id)
    {
        $user = app('auth')->guard()->user();
        $statement = Statement::findOrFail($id);

        if ($statement->user_id == $user->id) {
            $statement->delete();

            return response()->json(['status' => 'Deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'HOW CAN YOU SLAP'], 401);
        }
    }
}
