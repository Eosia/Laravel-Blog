@extends('layouts.main')

@section('content')

    <div class="row">

        <div class="col-lg-3">
            @include('includes.sidebar')
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Mot de passe oublié
                </div>
                <div class="card-body">

                    <form action="{{ route('post.forgot') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                            <div class="error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>

                    <div class="mt-5">
                        <p>
                            <a href="{{ route('register') }}">
                                Je n'ai pas de compte
                            </a>
                        </p>

                        <p>
                            <a href="{{ route('forgot') }}">
                                Mot de passe oublié
                            </a>
                        </p>
                    </div>

                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

@endsection
