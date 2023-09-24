@extends('layouts.main')

@section('content')

    <div class="row">

        <div class="col-lg-3">
            <div class="my-4">Catégories</div>
            <div class="list-group">
                <a href="#" class="list-group-item active">Laravel</a>
                <a href="#" class="list-group-item">PHP</a>
                <a href="#" class="list-group-item">Javascript</a>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            @foreach($articles as $article)

            <div class="card mt-4">

                <div class="card-body">
                    <h2 class="card-title">
                        <a href="{{ route('articles.show', ['article' => $article->id]) }}">
                            {{ $article->title }}
                        </a>
                    </h2>
                    <p class="card-text">
                        {{ Str::words($article->content, 10) }}
                    </p>

                    <span class="auhtor">Par <a href="">Hamid</a></span> <br>
                    <span class="time">{{ $article->created_at->diffForHumans() }}</span>
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
