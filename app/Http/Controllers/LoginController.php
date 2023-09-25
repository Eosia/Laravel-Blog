<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest');
    }



    // Affichage de la page de connexion
    public function index()
    {
        // Vérifiez si l'utilisateur est déjà connecté
        /*
        if (Auth::check()) {
            $error = "Vous êtes déjà connecté";
            return redirect('/')->withError($error);
        }
        */

        $data = [
            'title' => 'Login - ' . config('app.name'),
            'description' => 'Connexion à votre compte - ' . config('app.name'),
        ];
        return view('auth.login', $data);
    }

    // Fonction du traitement du formulaire de connexion
    public function login() {



        request()->validate([
            'email'=> 'required|email',
            'password' => 'required'
        ]);

        $remember = request()->has('remember');

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')], $remember)) {

            return redirect('/');
        }
        return back()->withError('Mauvais identifiants')->withInput();



    }


}










