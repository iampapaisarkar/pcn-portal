@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Add Schools', 'route' => 'schools.create'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">Add New School</div>
        <form method="POST" action="{{ route('schools.store') }}" enctype="multipart/form-data" novalidate>
        @csrf
            <div class="row">
            <div class="col-md-6 form-group mb-3">
                    <label for="name1">School Name</label>
                    <input value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" id="name1" type="text" placeholder="Enter school name" />
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="code1">School Code</label>
                    <input onkeyup="onCode(this)" value="{{ old('code') }}" name="code" class="form-control @error('code') is-invalid @enderror" id="code1" type="text" placeholder="Enter unique school code" />
                    <small id="codeHelp" class="form-text text-muted">*please ensure that. code should look like, e.g: "test_test" OR "test-test"</small> 
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    @php
                        $states = app('App\Http\Services\BasicInformation')->states();
                    @endphp
                    <label for="picker1">State</label>
                    <select value="" required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option  value="">Select State</option>
                        @foreach($states as $state)
                        <option hidden {{ old('state') == $state->id ? 'selected' : '' }} value="{{$state->id}}">{{$state->name}}</option>
                        <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="">Status</label> <br>
                    <input name="status" checked class="text-white" type="checkbox" data-toggle="toggle" data-on="ACTIVE" data-off="DISABLED" data-onstyle="success" data-offstyle="warning">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<style>
    .toggle-on{
        color: white!important;
    }
    .toggle-off{
        color: white!important;
    }
</style>

<script>
function onCode(){
    var str = $("#code1").val()
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes
    
    $("#code1").val(str)
}
</script>
@endsection