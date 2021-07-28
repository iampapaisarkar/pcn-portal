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
            <x-vendor-m-e-p-t-p-application/>
        @else
        <span>No application found!</span>
        @endif
        </div>

    </div>
</div>
@endsection