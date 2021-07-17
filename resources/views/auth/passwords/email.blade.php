@extends('layouts.app')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">Forgot Password</h1>
                        <form action="index.php">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control form-control" id="email" type="email">
                            </div>
                            <button class="btn btn-primary btn-block btn mt-3">Reset Password</button>
                        </form>
                        <div class="mt-3 text-center"><a class="text-muted" href="{{route('login')}}">
                                <u>Sign in</u></a></div>
                    </div>
                </div>
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pr-3 auth-right">
                    <a class="btn btn btn-outline-primary btn-outline-email btn-block btn-icon-text" href="{{ route('register') }}"><i class="i-Mail-with-At-Sign"></i> Register Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
