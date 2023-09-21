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


}
