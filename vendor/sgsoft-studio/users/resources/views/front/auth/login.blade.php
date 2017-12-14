@extends('webed-theme::front._master')

@section('content')
    <form method="POST" action="{{ request()->fullUrl() }}">
        {!! csrf_field() !!}
        <div class="form-group form-group-lg">
            <label for="exampleInputEmail1">Email</label>
            <input type="email"
                   class="form-control"
                   id="exampleInputEmail1"
                   placeholder="Email"
                   name="email">
        </div>
        <div class="form-group form-group-lg">
            <label for="exampleInputPassword1">Password</label>
            <input type="password"
                   class="form-control"
                   id="exampleInputPassword1"
                   placeholder="Password"
                   name="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
        </div>
        <p class="text-center mt20"><a href="{{ route('front::auth.forgot_password.get') }}">Forget password</a></p>
    </form>
@endsection
