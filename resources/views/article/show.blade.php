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

                <div class="card mt-4">

                    <div class="card-body">
                        <h1 class="card-title">
                                {{ $article->title }}
                        </h1>
                        <p class="card-text">
                            {{ $article->content }}
                        </p>

                        <span class="auhtor">
                        Par
                        <a href="{{ route('user.profile', ['user' => $article->user->id]) }}">
                            {{ $article->user->name }}
                        </a>
                    </span>
                        <br>
                        <span class="time">Posté le {{ $article->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <!-- /.card -->


        </div>
        <!-- /.col-lg-9 -->

    </div>

@endsection
