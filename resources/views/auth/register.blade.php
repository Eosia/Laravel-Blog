

@extends('layouts.main')

@section('content')

<div class="row">

        <div class="col-lg-3">
            @include('includes.sidebar')
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Inscription
                </div>
                <div class="card-body">

                    <form>
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" name="nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <!--
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        -->
                        <button type="submit" class="btn btn-primary">Inscription/button>
                    </form>

                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>


@endsection
