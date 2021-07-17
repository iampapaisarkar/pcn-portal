@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Profile', 'route' => 'profile'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="{{ route('profile-update') }}">
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
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="credit1" placeholder="Card" value="{{Auth::user()->role->role}}" readonly/>
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
                    <label for="picker1">State</label>
                    <select required name="state" class="form-control @error('state') is-invalid @enderror">
                        <option hidden selected value="{{Auth::user()->state}}">{{Auth::user()->state}}</option>
                        <option {{!Auth::user()->state ? 'selected' : ''}} value="">Select State</option>
                        <option value="Abia">Abia</option>
                        <option value="Adamawa">Adamawa</option>
                        <option value="Anambra">Anambra</option>
                        <option value="Akwa Ibom">Akwa Ibom</option>
                        <option value="Bauchi">Bauchi</option>
                        <option value="Bayelsa">Bayelsa</option>
                        <option value="Benue">Benue</option>
                        <option value="Borno">Borno</option>
                        <option value="Cross River">Cross River</option>
                        <option value="Delta">Delta</option>
                        <option value="Ebonyi">Ebonyi</option>
                        <option value="Enugu">Enugu</option>
                        <option value="Edo">Edo</option>
                        <option value="Ekiti">Ekiti</option>
                        <option value="Gombe">Gombe</option>
                        <option value="Imo">Imo</option>
                        <option value="Jigawa">Jigawa</option>
                        <option value="Kaduna">Kaduna</option>
                        <option value="Kano">Kano</option>
                        <option value="Katsina">Katsina</option>
                        <option value="Kebbi">Kebbi</option>
                        <option value="Kogi">Kogi</option>
                        <option value="Kwara">Kwara</option>
                        <option value="Lagos">Lagos</option>
                        <option value="Nasarawa">Nasarawa</option>
                        <option value="Niger">Niger</option>
                        <option value="Ogun">Ogun</option>
                        <option value="Ondo">Ondo</option>
                        <option value="Osun">Osun</option>
                        <option value="Oyo">Oyo</option>
                        <option value="Plateau">Plateau</option>
                        <option value="Rivers">Rivers</option>
                        <option value="Sokoto">Sokoto</option>
                        <option value="Taraba">Taraba</option>
                        <option value="Yobe">Yobe</option>
                        <option value="Zamfara">Zamfara</option>
                        <option value="FCT Abuja">FCT Abuja</option>
                    </select>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="picker1">LGA</label>
                    <select required name="lga" class="form-control @error('lga') is-invalid @enderror">
                        <option hidden selected value="{{Auth::user()->lga}}">{{Auth::user()->lga}}</option>
                        <option  {{!Auth::user()->lga ? 'selected' : ''}} value="">Select LGA</option>
                        <option value="Alimosho">Alimosho</option>
                        <option value="Agege">Agege</option>
                        <option value="Ajeromi Ifelodun">Ajeromi Ifelodun</option>
                        <option value="Apapa">Apapa</option>
                        <option value="Amuwo Odofin">Amuwo Odofin</option>
                        <option value="Badagry">Badagry</option>
                        <option value="Epe">Epe</option>
                        <option value="Eti Osa">Eti Osa</option>
                        <option value="Ibeju-Lekki">Ibeju-Lekki</option>
                        <option value="Ifako Ijaiye">Ifako Ijaiye</option>
                        <option value="Ikeja">Ikeja</option>
                        <option value="Ikorodu">Ikorodu</option>
                        <option value="Kosofe">Kosofe</option>
                        <option value="Lagos Island">Lagos Island</option>
                        <option value="Lagos Mainland">Lagos Mainland</option>
                        <option value="Mushin">Mushin</option>
                        <option value="Ojo">Ojo</option>
                        <option value="Oshodi/Isolo">Oshodi/Isolo</option>
                        <option value="Shomolu">Shomolu</option>
                        <option value="Surulere">Surulere</option>
                    </select>
                    @error('lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4 form-group mb-3">
                    <label for="picker2">Date of Birth</label>
                    <input name="dob" class="form-control @error('dob') is-invalid @enderror" id="picker2" value="{{Auth::user()->dob}}" placeholder="dd-mm-yyyy" name="dp" required />
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
                </div>
                @endcan
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection