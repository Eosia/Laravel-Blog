<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{

    // Formulaire d'inscription au site
    public function index() {
        $data = [
            'title' => 'Inscription',
            'description' => 'Inscription sur le site ' . config('app.name'),
        ];

        return view('auth.register', $data);

    }

    // Fonction du traitement du formulaire d'inscription
    public function register() {
        request()->validate([
            'name' => 'required|min:3|max:191|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:8,36',
        ]);
    }


}
