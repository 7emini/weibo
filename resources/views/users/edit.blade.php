@extends('layouts.default')
@section('title', '修改用户')
@section('content')
    <div class="offset-md-2 col-md-8">
        @include('shared._errors')
        <div class="card">
            <div class="card-header">
                <h5>修改用户</h5>
            </div>
            <div class="gravatar_edit">
                <a href="http://gravatar.com/emails" target="_blank">
                    <img class="gravatar" src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" >
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', [$user]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                        <label for="name">昵称</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" name="password" class="form-control" value={{ old('password') }}>
                    </div>


                    <div class="form-group">
                        <label for="password_confirmation">确认密码</label>
                        <input type="password" name="password_confirmation" class="form-control"}}>
                    </div>
                    <button type="submit" class="btn btn-primary">修改</button>
                </form>
            </div>
        </div>
    </div>
@endsection