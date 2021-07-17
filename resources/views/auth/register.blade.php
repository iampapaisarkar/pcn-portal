@extends('layouts.guest')

@section('content')
<div class="auth-layout-wrap" style="background-image: url({{asset('admin/dist-assets/images/photo-wide-44.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('admin/dist-assets/images/photo-long-3.jpg')}})">
                    <div class="pl-3 auth-right">
                        <div class="auth-logo text-center mt-4"><img src="{{asset('admin/dist-assets/images/logo.png')}}" alt=""></div>
                        <h1 class="mb-3 text-18">Existing Users</h1>
                            <h2 class="mb-3 text-14">If you have created a profile on this portal before now, please login</h2>
                        <div class="flex-grow-1"></div>
                        <div class="w-100 mb-4">
                        
                        <a class="btn btn-outline-primary btn-block btn-icon-text btn" href="{{ route('login') }}"><i class="i-Mail-with-At-Sign"></i> Sign in</a>
                        </div>
                        <div class="flex-grow-1"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <h1 class="mb-3 text-18">Sign Up</h1>
                        <form action="">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input class="form-control form-control" id="firstname" type="text">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input class="form-control form-control" id="lastname" type="text">
                            </div>
                            <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" class="form-control " type="text" value="">
									<div class="validation-error">
										
									</div>
                                </div>
								<div class="form-group">
								    <label for="picker1">User Type</label>
									<select class="form-control" name="type">
                                    <option value="" >Select</option>
                                    <option value="4" selected="selected">Tiered Patent Medicine Shop</option>
                                    </select>
									<div class="validation-error">
										
									</div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control form-control" id="email" type="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control form-control" id="password" type="password">
                            </div>
                            <div class="form-group">
                                <label for="repassword">Retype password</label>
                                <input class="form-control form-control" id="repassword" type="password">
                            </div>
                            <button class="btn btn-primary btn-block btn mt-3">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
