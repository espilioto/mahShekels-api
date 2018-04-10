<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $salt;
    public function __construct()
    {
        $this->salt = "youshallnotpass \o/";
        $this->middleware('auth', ['only' => ['resetToken']]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($request->has('email') && $request->has('password')) {
            $user = new User;
            $user->email = $request->input('email');
            $user->password = sha1($this->salt . $request->input('password'));
            $user->email = $request->input('email');
            $user->api_token = str_random(60);
            $user->save();

            return response()->json($user->api_token);
        } else {
            return response()->json(['gief email and pass m8']);
        }
    }
}
