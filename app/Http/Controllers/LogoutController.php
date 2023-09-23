<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LogoutController extends Controller
{
    // Traitement de la déconnexion
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }


}
