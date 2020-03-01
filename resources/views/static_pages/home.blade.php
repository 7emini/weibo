@extends('layouts.default')
@section('title', 'Home')
@section('content')
@if (Auth::check())
    <div class="row">
        <div class="col-md-8">
            @include('shared._status_form')
        </div>
        <div class="col-md-4">
            <section class="user_info">
                @include('shared._user_info', ['user'=>Auth::user()])
            </section>
        </div>
    </div>
@else
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            你现在看到的是<a href="{{ route('home') }}">Laravel6 入门教程</a> 的示例项目主页。
        </p>
        <p>
            一切，将从这里开始
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="{{ route('signup') }}">现在注册</a>
        </p>
    </div>
@endif
@endsection