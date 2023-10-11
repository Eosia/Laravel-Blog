<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

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

        $user = auth()->user();

        request()->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'avatar' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png'],
        ]);
    }



}
