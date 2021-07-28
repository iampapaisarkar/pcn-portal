@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Status', 'route' => 'meptp-application-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
        @if(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['is_status'] == true)
            <h4>MEPTP Application Status - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['color']}}" role="alert">
                        <p>{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['message']}}</p>
                        @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['caption']))
                        <p><strong>REASONS: </strong></p>
                        <p>{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['caption']}}</p>
                        @endif
                    </div>
                </div>
            </div>
            @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['edit']) && app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['edit'] == true)
            <a href="{{route('meptp-application-edit')}}" class="btn  btn-primary m-1" name="save">Update MEPTP Application</a>
            @endif
            <x-vendor-m-e-p-t-p-application 
            :applicationID="app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['application_id']" 
            :vendorID="app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['vendor_id']"
            />
        @else
        <span>No application found!</span>
        @endif
        </div>

    </div>
</div>
@endsection