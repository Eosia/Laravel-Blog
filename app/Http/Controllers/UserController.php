<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;
use Nette\Schema\ValidationException;
use Storage, Image, Str, DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('profile');
    }

    public function profile(User $user)
    {

        $articles = $user->articles()->withCount('comments')->latest()->paginate(5);

        $data = [
            'title' => 'Profil de ' . $user->name,
            'description' => $user->name . ' est inscrit depuis le ' . $user->created_at->isoFormat('LL') .
                ' et a posté ' . $user->articles()->count() . ' Article(s)',
            'user' => $user,
            'articles' => $articles,
        ];

        return view('user.profile', $data);
    }

    public function edit()
    {
        $user = auth()->user();
        $data = [
            'title' => $description = 'Editer mon profil',
            'description' => $description,
            'user' => $user,
        ];
        return view('user.edit', $data);
    }

    // reset du mot de passe
    public function password() {
        $data = [
            'title' => $description = 'Modifier mon mot de passe',
            'description' => $description,
            'user' => auth()->user(),
        ];
        return view('user.password', $data);
    }

    // mise à jour du mot de passe
    public function updatePassword() {
        request()->validate([
            'current' => 'required|password',
            'password' => 'required|between:4,32|confirmed',
        ]);

        $user = auth()->user();
        $user->password = bcrypt(request('password'));
        $user->save();

        $success = 'Mot de passe mis à jour';

        return back()->withSuccess($success);
    }

    public function store()
    {

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user = $user->updateOrCreate(['id' => $user->id],
                request()->validate([
                    'name' => ['required', 'min:3', 'max:20', Rule::unique('users')->ignore($user)],
                    'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                    'avatar' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'dimensions:min_width=200,min_height=200'],
                ]));

            if (request()->hasFile('avatar') && request()->file('avatar')->isValid()) {

                if (Storage::exists('avatar/' . $user->id)) {
                    Storage::deleteDirectory('avatars/' . $user->id);
                }

                $ext = request()->file('avatar')->extension();
                $filename = Str::slug($user->name) . '-' . $user->id . '.' . $ext;

                $path = request()->file('avatar')->storeAs('avatars/' . $user->id, $filename);

                $thumbnailImage = Image::make(request()->file('avatar'))->fit(200, 200, function ($constraint) {
                    $constraint->upsize();
                })->encode($ext, 50);

                $thumbnailPath = 'avatars/' . $user->id . '/tumbnail/' . $filename;

                Storage::put($thumbnailPath, $thumbnailImage);
                $user->avatar()->updateOrCreate(['user_id' => $user->id], [
                    'filename' => $filename,
                    'url' => Storage::url($path),
                    'path' => $path,
                    'thumb_url' => Storage::url($thumbnailPath),
                    'thumb_path' => $thumbnailPath
                ]);
            }
        }

        catch(ValidationException $e) {
            DB::rollback();
            dd($e->getErrors());
        }

        DB::commit();

        $success = 'Informations mises à jour';
        return back()->withSuccess($success);


    }


}
