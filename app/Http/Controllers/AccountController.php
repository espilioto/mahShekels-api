<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = app('auth')->guard()->user();

        return response()->json($user->accounts);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $user = app('auth')->guard()->user();

        if ($request->has('name')) {
            $account = new Account;
            $account->name = $request->input('name');
            $account->user_id = $user->id;
            $account->save();

            return response()->json($account, 201);
        } else {
            return response()->json(['body error']);
        }

        // return response()->json($statement, 201);
    }

    public function update($id, Request $request)
    {
        $user = app('auth')->guard()->user();
        $account = Account::findOrFail($id);

        if ($account->user_id == $user->id) {
            $account->update($request->all());

            return response()->json($account, 200);
        } else {
            return response()->json('HOW CAN YOU SLAP', 401);
        }
    }

    public function delete($id)
    {
        $user = app('auth')->guard()->user();
        $account = Account::findOrFail($id);

        if ($account->user_id == $user->id) {
            $account->delete();

            return response('Deleted Successfully', 200);
        } else {
            return response('HOW CAN YOU SLAP', 401);
        }
    }
}
