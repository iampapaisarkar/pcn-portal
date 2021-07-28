@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Result', 'route' => 'meptp-application-result'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
        @if(app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['is_result'] == true)
            <h4>MEPTP Application Result - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['message']}}
                        @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['download_result']))
                        <button class="btn btn-rounded btn-success ml-3">Download Result</button>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            <x-vendor-m-e-p-t-p-application 
            :applicationID="app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['application_id']" 
            :vendorID="app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['vendor_id']"
            />
        @else
        <span>No result found!</span>
        @endif
        </div>

    </div>
</div>
@endsection