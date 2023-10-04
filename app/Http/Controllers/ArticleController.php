<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Article,
    Category,
};
use Str, Auth;
use App\Http\Requests\ArticleRequest;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except('index', 'show');
    }

    protected $perPage = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::orderByDesc('id')->paginate($this->perPage);

        $data = [
            'title' => 'Les articles du blog - ' . config('app.name'),
            'description' => 'Retrouvez tous les articles de ' . config('app.name'),
            'articles' => $articles,
        ];
        return view('article.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get();

        $data = [
          'title' => $description = 'Ajouter un nouvel article',
            'description' => $description,
            'categories' => $categories,
        ];
        return view('article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //

        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);
        Auth::user()->articles()->create($validatedData);


        /*
        $article = Auth::user()->articles()->create(request()->validate([
            'title' => ['required', 'max:20', 'unique:articles,title'],
            'content' => ['required'],
            'category' => ['sometimes', 'nullable', 'exists:categories,id'],
        ]));

        $article->category_id = request('category', null);
        $article->save();
        */

        /*
        $article = New Article;
        $article->user_id = Auth::id();
        $article->category_id = request('category',  null);
        $article->title = request('title');
        $article->slug = Str::slug($article->title);
        $article->content = request('content');
        $article->save();
        */

        /*
        $article = Article::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'content' => request('content'),
            'category_id' => request('category', null),
        ]);
        */

        $success = "Article ajouté";

        return back()->withSuccess($success);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
        $data = [
            'title' => $article->title . ' - ' . config('app.name'),
            'description' => $article->title . ' . ' . Str::words($article->content, 5),
            'article' => $article,
            'comments' => $article->comments()->orderByDesc('created_at')->get(),
        ];
        return view('article.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
        abort_if(auth()->id() != $article->user_id, 403);

        $data = [
            'title' => $description = 'Mise à jour de ' . $article->title,
            'description' => $description,
            'article' => $article,
            'categories' => Category::get(),
        ];
        return view('article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        //
        abort_if(auth()->id() != $article->user_id, 403);

        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);
        $article = Auth::user()->articles()->updateOrCreate(['id' => $article->id], $validatedData);

        $success = "Article modifié";

        return redirect()->route('article.edit', ['article' => $article->slug])->withSuccess($success);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
        abort_if(auth()->id() != $article->user_id, 403);
        $article->delete();
        $success = 'Article supprimé';
        return back()->withSuccess($success);
    }
}
