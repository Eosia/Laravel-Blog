<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    }


}
