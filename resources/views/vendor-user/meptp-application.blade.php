@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application', 'route' => 'meptp-application'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
            <!--begin::form-->
            <form method="POST" action="tppmv-metpt-invoice.php" enctype="multipart/form-data"><input name="_token"
                    type="hidden">
                <input type="hidden" name="_token" value="8abYHncZyjFCfeQqdvp891Ipt7qgcQc0beYIZXOu">

                <h4>Vendor Details</h4>
                <div class="row">
                    <div class="form-group col-md-6">
                        <img style="width: 25%;" src="{{Auth::user()->photo ? asset(Auth::user()->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
                    </div>
                    <div class="form-group col-md-6">
                        <h3>Batch Details: {{app('App\Http\Services\BasicInformation')->activeBatch()->batch_no . '/' . app('App\Http\Services\BasicInformation')->activeBatch()->year}}<h3>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="firstName1">First name</label>
                        <input name="firstname" class="form-control @error('firstname') is-invalid @enderror"
                            id="firstName1" type="text" placeholder="Enter your first name"
                            value="{{Auth::user()->firstname}}" readonly />
                        @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="middleName1">Last name</label>
                        <input name="lastname" class="form-control @error('lastname') is-invalid @enderror"
                            id="middleName1" type="text" placeholder="Enter your middle name"
                            value="{{Auth::user()->lastname}}" readonly />
                        @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="haddress">Address:</label>
                        <input name="address" class="form-control @error('address') is-invalid @enderror"
                            value="{{Auth::user()->address}}" id="address" placeholder="Address"  readonly />
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="huser_state">State:</label>
                        <input name="user_state" class="form-control @error('user_state') is-invalid @enderror"
                            value="{{Auth::user()->user_state->name}}" id="user_state" placeholder="user_state"  readonly />
                        @error('user_state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="huser_lga">LGA:</label>
                        <input name="user_lga" class="form-control @error('user_lga') is-invalid @enderror"
                            value="{{Auth::user()->user_lga->name}}" id="user_lga" placeholder="user_lga"  readonly />
                        @error('user_lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="custom-separator"></div>
                <h4>Documents Upload</h4>


                <div class="custom-separator"></div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Birth Certificate or Declaration of Age:</label>
                        <div class="custom-file mb-3">
                            <input name="birth_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('birth_certificate') is-invalid @enderror"
                                id="inputGroupFile01" accept="image/*">
                            <label class="custom-file-label " for="inputGroupFile01"
                                aria-describedby="inputGroupFileAddon02">Choose file</label>
                            @error('birth_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-center">
                        <img id="inputGroupFile01preview" src="" alt="" class="w-100">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Birth Certificate or Declaration of Age:</label>
                        <div class="custom-file mb-3">
                            <input name="educational_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('educational_certificate') is-invalid @enderror"
                                id="inputGroupFile02" accept="image/*">
                            <label class="custom-file-label " for="inputGroupFile02"
                                aria-describedby="inputGroupFileAddon02">Choose file</label>
                            @error('educational_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-center">
                        <img id="inputGroupFile02preview" src="" alt="" class="w-100">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Health Related Academic Training:</label>
                        <div class="custom-file mb-3">
                            <input name="academic_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('academic_certificate') is-invalid @enderror"
                                id="inputGroupFile03" accept="image/*">
                            <label class="custom-file-label " for="inputGroupFile03"
                                aria-describedby="inputGroupFileAddon02">Choose file</label>
                            @error('academic_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-center">
                        <img id="inputGroupFile03preview" src="" alt="" class="w-100">
                    </div>
                </div>
                <div class="custom-separator"></div>
                <h4>Patent Medicine Vendor Shop</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="ul-form__label">Shop Name:</label>
                        <input name="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                        value="{{ old('shop_name') }}"
                        id="shop_name" placeholder="Enter shop name" />
                        @error('shop_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Phone:</label>
                        <input name="shop_phone" class="form-control @error('shop_phone') is-invalid @enderror"
                        value="{{ old('shop_phone') }}"
                        id="shop_phone" placeholder="Enter shop phone" />
                        @error('shop_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Email:</label>
                        <input name="shop_phone" class="form-control @error('shop_email') is-invalid @enderror"
                        value="{{ old('shop_phone') }}"
                        id="shop_email" placeholder="Enter shop email" />
                        @error('shop_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Address:</label>
                        <input name="shop_address" class="form-control @error('shop_address') is-invalid @enderror"
                        value="{{ old('shop_address') }}"
                        id="shop_address" placeholder="Enter shop address" />
                        @error('shop_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Town/City:</label>
                        <input name="city" class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city') }}"
                        id="city" placeholder="Enter Town/City" />
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">State:</label>
                        @php
                        $states = app('App\Http\Services\BasicInformation')->states();
                        @endphp
                        <select id="stateField" required name="state"
                            class="form-control @error('state') is-invalid @enderror">
                            <option {{ old('state') ? '' : 'seleted' }} hidden value="">Select State</option>
                            @foreach($states as $state)
                                @if(old('state') == $state->id)
                                <option {{ old('state') ? 'seleted' : '' }} hidden value="{{ $state->id }}">{{ $state->name }}</option>
                                @endif
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if(old('state'))
                    <div class="form-group col-md-3">
                        <label for="lgaField" class="ul-form__label">LGA: </label>
                        @php
                        $lgas = app('App\Http\Services\BasicInformation')->lgas();
                        @endphp
                        <select id="lgaField" required name="lga"
                            class="form-control @error('lga') is-invalid @enderror">
                            @foreach($lgas as $lga)
                            @if(old('state') == $lga->state_id)
                            <option value="{{$lga->id}}">{{$lga->name}}</option>
                            @endif
                            <option value="{{$lga->id}}">{{$lga->name}}</option>
                            @endforeach
                        </select>
                        @error('lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @else
                    <div class="form-group col-md-3">
                        <label for="lgaField" class="ul-form__label">LGA: </label>
                        @php
                        $lgas = app('App\Http\Services\BasicInformation')->lgas();
                        @endphp
                        <select {{old('lga') ? '' : 'disabled'}} id="lgaField" required name="lga"
                            class="form-control @error('lga') is-invalid @enderror">
                            <option selected value="">Select LGA</option>
                            @foreach($lgas as $lga)
                                @if(old('lga') == $lga->id)
                                <option {{ old('lga') ? 'seleted' : '' }} hidden value="{{ $lga->id }}">{{ $lga->name }}</option>
                                @endif
                            <option value="{{$lga->id}}">{{$lga->name}}</option>
                            @endforeach
                        </select>
                        @error('lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endif


                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">Are you registered? </label>
                        <select id="is_registeredField" required name="is_registered"
                            class="form-control @error('is_registered') is-invalid @enderror">
                            <option {{old('is_registered') ? '' : 'selected'}} hidden value="">Select</option>
                            @if(old('is_registered') == 'yes')
                            <option selected hidden value="yes">Yes</option>
                            @else
                            <option selected hidden value="no">No</option>
                            @endif
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        @error('is_registered')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div id="ppmvl_noField" style="{{old('ppmvl_no') ? old('ppmvl_no') : 'display: none;'}}" class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">PPMVL Number :</label>
                        <input name="ppmvl_no" class="form-control @error('ppmvl_no') is-invalid @enderror"
                        value="{{old('ppmvl_no')}}"
                        id="ppmvl_no" placeholder="Enter Town/ppmvl_no" />
                        @error('ppmvl_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="custom-separator"></div>


                <h4>Training Centre</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="ul-form__label">Preferred Training Centre</label>
                        @php
                        $schools = app('App\Http\Services\BasicInformation')->schools();
                        @endphp
                        <select id="schoolField" required name="school"
                            class="form-control @error('school') is-invalid @enderror">
                            <option {{ old('school') ? '' : 'seleted' }} hidden value="">Select school</option>
                            @foreach($schools as $school)
                                @if(old('school') == $school->id)
                                <option {{ old('school') ? 'seleted' : '' }} hidden value="{{ $school->id }}">{{ $school->name }}</option>
                                @endif
                            <option value="{{$school->id}}">{{$school->name}}</option>
                            @endforeach
                        </select>
                        @error('school')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn  btn-primary m-1" id="save" name="save">Submit MEPTP
                                    Application</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Birth Certificate Photo on upload preview 
inputGroupFile01.onchange = evt => {
    const [file] = inputGroupFile01.files
    if (file) {
        $('#inputGroupFile01preview').attr('src', URL.createObjectURL(file));
    }
}

// Educational Certificate Photo on upload preview 
inputGroupFile02.onchange = evt => {
    const [file] = inputGroupFile02.files
    if (file) {
        $('#inputGroupFile02preview').attr('src', URL.createObjectURL(file));
    }
}

// Academic Certificate Photo on upload preview 
inputGroupFile03.onchange = evt => {
    const [file] = inputGroupFile03.files
    if (file) {
        $('#inputGroupFile03preview').attr('src', URL.createObjectURL(file));
    }
}

// State Selection 
$('#stateField').on('change', function() {
    var value = this.value;
    if (value && value.length != null) {
        $('#lgaField').removeAttr('disabled');
        var lgas = <?php if(isset($lgas)){echo $lgas;} ?>;
        var optionsHTML = '<option selected value="">Select LGA</option>';
        lgas.forEach(lga => {
            if (lga.state_id == value) {
                optionsHTML += '<option value="' + lga.id + '">' + lga.name + '</option>'
            }
        });
        $('#lgaField').html(optionsHTML);
    } else {
        $('#lgaField').html('<option selected value="">Select LGA</option>');
        $('#lgaField').attr('disabled');
    }
});

// Check Is Register Selection 
$('#is_registeredField').on('change', function() {
    var value = this.value;
    if (value && value == 'yes') {
        $("#ppmvl_noField").show();
    } else {
        $("#ppmvl_noField").hide();
    }
});
</script>
<style>
.profilePreview img {
    border-radius: 100%;
}
</style>
@endsection