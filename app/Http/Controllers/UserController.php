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
            'email' => 'required|email|unique:users,email',
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
            return response()->json(['status' => 'gief email and pass m8'], 400);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($request->has('email') && $request->has('password')) {
            $user = User::where("email", "=", $request->input('email'))
                ->where("password", "=", sha1($this->salt . $request->input('password')))
                ->first();
            if ($user) {
                $user->api_token = str_random(60);
                $user->save();
                return $user->api_token;
            } else {
                return response()->json(['status' => 'rip'], 401);
            }
        } else {
            return response()->json(['status' => 'rip'], 400);
        }
    }
}
