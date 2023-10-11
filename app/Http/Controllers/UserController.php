<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except('profile');
    }

    public function profile(User $user) {
        return 'Je suis un utilisateur ' . $user->name;
    }

    public function edit() {
        $user = auth()->user();
        $data = [
            'title' => $description = 'Editer mon profil',
            'description' => $description,
            'user' => $user,
        ];
        return view('user.edit', $data);
    }

    public function store() {

    }



}
