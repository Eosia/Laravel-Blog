@extends('layouts.main')

@section('content')

    <div class="row">

        <div class="col-lg-3">

            @include('includes.sidebar')

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            @if(session('success'))
                <div class="alert alert-success my-5">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($articles as $article)

            <div class="card mt-4">

                <div class="card-body">
                    <h2 class="card-title">
                        <a href="{{ route('articles.show', ['article' => $article->slug]) }}">
                            {{ $article->title }}
                        </a>
                    </h2>
                    <p class="card-text">
                        {{ Str::words($article->content, 10) }}
                    </p>

                    <span class="auhtor">
                        Par
                        <a href="{{ route('user.profile', ['user' => $article->user->id]) }}">
                            {{ $article->user->name }}
                        </a>
                    </span>
                    <br>

                    <span class="time">Posté le {{ $article->created_at->diffForHumans() }}</span>

                    @if(Auth::check() && Auth::user()->id == $article->user_id)
                    <div class="author">
                        <a href="{{ route('articles.edit', ['article' => $article->slug]) }}" class="btn btn-info">
                            Modifier
                        </a>
                        &nbsp
                        <form style="display: inline" action="{{ route('articles.destroy', ['article' => $article->slug]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Supprimer
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
            <!-- /.card -->

            @endforeach

            {{--Pagination--}}
            <div class="pagination my-5">
                {{ $articles->links() }}
            </div>
            {{--Pagination/--}}

        </div>
        <!-- /.col-lg-9 -->

    </div>

@endsection
