@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-center">
                        {{--<img src="{{URL::asset('/images/logo.png')}}" class="img-rounded" alt="Cinque Terre" width="136" height="56">--}}
                        <h3>{{--Sign in to Iris English--}}Admin Login</h3>
                    </div>
                </div>

                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{--<div class="form-group">
                            <div class="col-md-offset-1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>--}}

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">
                                Login
                            </button>

                            {{--<a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>--}}
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body text-center">
                        @ 2017 Powered by iris
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
