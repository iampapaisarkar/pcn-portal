@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Add Users', 'route' => 'users.create'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">Add New User</div>
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
            <div class="row">
            <div class="col-md-6 form-group mb-3">
                    <label for="firstName1">First name</label>
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstName1" type="text" placeholder="Enter your first name" />
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="middleName1">Last name</label>
                    <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="middleName1" type="text" placeholder="Enter your middle name" />
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" type="email" placeholder="Enter email"/>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> 
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="phone">Phone</label>
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone"/>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="col-md-6 form-group mb-3">
                    <label for="picker1">User Type</label>
                    <select id="userTypeField" required name="type" class="form-control @error('state') is-invalid @enderror">
                        @foreach($roles as $role)
                        <option value="{{$role->code}}">{{$role->role}}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div id="stateColumn" class="col-md-6 form-group mb-3" style="display:none;">
                    @php
                        $states = app('App\Http\Controllers\HomeController')->states();
                    @endphp
                    <label for="picker1">State (State Office)</label>
                    <select required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option  value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
$('#userTypeField').on('change', function() {
    var value = this.value;
    console.log("value", value)
    if(value && value == 'state_office'){
        $('#stateColumn').show();
    }else{
        $('#stateColumn').hide();
    }
});
</script>
@endsection