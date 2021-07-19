@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Profile', 'route' => 'profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        @if (session('status'))
            <div class="alert alert-warning">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('profile-update') }}" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label for="firstName1">First name</label>
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstName1" type="text" placeholder="Enter your first name" value="{{Auth::user()->firstname}}" readonly />
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="middleName1">Last name</label>
                    <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="middleName1" type="text" placeholder="Enter your middle name" value="{{Auth::user()->lastname}}" readonly />
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" type="email" placeholder="Enter email"   value="{{Auth::user()->email}}"  readonly/>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> 
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="phone">Phone</label>
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone"  value="{{Auth::user()->phone}}"  readonly/>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="credit1">Profile Type</label>
                    <input name="type" class="form-control @error('phone') is-invalid @enderror" id="credit1" placeholder="Card" value="{{Auth::user()->role->role}}" readonly/>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @can('isVendor')
                <div class="col-md-4 form-group mb-3">
                    <label for="haddress">Address:</label>
                    <input name="address" class="form-control @error('address') is-invalid @enderror" value="{{Auth::user()->address}}" id="address" placeholder="Address" required />
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    @php
                        $states = app('App\Http\Controllers\HomeController')->states();
                    @endphp
                    <label for="picker1">State</label>
                    <select id="stateField" required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option hidden selected value="{{Auth::user()->user_state->id}}">{{Auth::user()->user_state->name}}</option>
                        <option {{!Auth::user()->state ? 'selected' : ''}} value="">Select State</option>
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
                <div class="col-md-4 form-group mb-3">
                    @php
                        $lgas = app('App\Http\Controllers\HomeController')->lgas();
                    @endphp
                    <label for="picker1">LGA</label>
                    <select {{!Auth::user()->lga ? 'disabled' : ''}} id="lgaField" required name="lga" class="form-control @error('lga') is-invalid @enderror">
                        <option hidden selected value="{{Auth::user()->user_lga->id}}">{{Auth::user()->user_lga->name}}</option>
                        <option  {{!Auth::user()->lga ? 'selected' : ''}} value="">Select LGA</option>
                    </select>
                    @error('lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="picker2">Date of Birth</label>
                    <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="picker2" value="{{Auth::user()->dob}}" placeholder="dd-mm-yyyy" name="dp" required />
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="picker1">Passport Photo</label>
                    <div class="custom-file">
                    <input name="photo" type="file" name="color_passportsize" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                    <label class="custom-file-label " for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                    </div>
                    <img src="{{asset('images/' . Auth::user()->photo)}}" alt="" class="w-25">
                </div>
                @endcan
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
	$('#stateField').on('change', function() {
	var value = this.value;
    if(value && value.length != null){
        $('#lgaField').removeAttr('disabled');
        var lgas = <?php echo $lgas ?>;
        var optionsHTML = '';
        lgas.forEach(lga => {
            if(lga.state_id == value){
                optionsHTML += '<option value="'+lga.id+'">'+lga.name+'</option>'
            }
        });
        $('#lgaField').html(optionsHTML);
    }else{
        $('#lgaField').html('<option selected value="">Select LGA</option>');
        $('#lgaField').attr('disabled');
    }
	});
</script>
@endsection