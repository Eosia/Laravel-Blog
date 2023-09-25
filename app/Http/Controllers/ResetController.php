<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str, DB;
use App\Models\User;

class ResetController extends Controller
{

    public function __construct() {
        $this->middleware('guest');
    }


    // Formulaire de réinitialisation de mot de passe
    public function index(string $token)
    {
        $password_reset = DB::table('password_resets')->where('token', $token)->first();

        abort_if(!$password_reset, 403);

        $data = [
            'title' => $description = "Réinitialisation de mot de passe - " . config('app.name'),
            'description' => $description,
            'password_reset' => $password_reset,
        ];
        return view('auth.reset', $data);
    }

    // Traitement du formulaire de réinitialisation du mot de passe
    public function reset()
    {

        request()->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|between:4,36|confirmed',
        ]);

        if (! DB::table('password_resets')
            ->where('email', request('email'))
            ->where('token', request('token'))->count())

        {
            $error = "L'adresse email entrée ne correspond pas à celle du token";
            return back()->withError($error)->withInput();
        }

        $user = User::whereEmail(request('email'))->firstOrFail();

        $user->password = bcrypt(request('password'));
        $user->save();

        DB::table('password_resets')->where('email', request('email'))->delete();

        $success = "votre mot de passe a bien été changé";

        return redirect()->route('login')->withSuccess($success);

    }
}
