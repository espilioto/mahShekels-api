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

    public function showAllStatements()
    {
        return response()->json(Statement::with('account', 'category', 'user')->get());
    }

    public function showOneStatement($id)
    {
        return response()->json(Statement::where('id', $id)->with('account', 'category', 'user')->get());
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
            'user_id' => 'required',
        ]);

        $statement = Statement::create($request->all());

        return response()->json($statement, 201);
    }

    public function update($id, Request $request)
    {
        $statement = Statement::findOrFail($id);
        $statement->update($request->all());

        return response()->json($statement, 200);
    }

    public function delete($id)
    {
        Statement::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
