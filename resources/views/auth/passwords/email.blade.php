@extends('layouts.default')
@section('title', '重置密码')

@section('content')
<div class="col-8 offset-md-2">
    <div class="card">
        <div class="card-header">
            <h5>发送重置密码邮件</h5>
        </div>
        <div class="card-body">
            @if (session()->has('status'))
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email" class="form-control-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @if($errors->has('email'))
                    <span class="form-text">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        发送重置密码邮件
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection