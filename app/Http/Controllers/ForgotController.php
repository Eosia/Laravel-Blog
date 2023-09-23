<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PasswordResetNotification;
use App\Models\User;
use Str, DB;

class ForgotController extends Controller
{
    // Formulaire d'oublie de mot de passe
    public function index() {
        $data = [
            'title' => $description = 'Mot de passe oublié - ' . config('app.name'),
            'description' => $description,
        ];

        return view('auth.forgot', $data);
    }

    // Vérification des datas et envoi du lien par mail
    public function store() {
        request()->validate([
            'email' => 'required|email|exists:users'
        ]);

        $token = Str::uuid();

        DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token,
            'created_at' => now(),
        ]);

        // envoi de notification avec lien avec token

        $user = User::whereEmail(request('email'))->firstOrFail();
        $user->notify(new PasswordResetNotification($token));

        $success = "Vérifier votre boite email et suivez les instructions";
        return back()->withSuccess($success);

    }


}
