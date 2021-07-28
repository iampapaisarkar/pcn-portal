@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Review Pending', 'route' => 'meptp-pending-batches'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>MEPTP Applications - Documents Review Pending</h4>
        <x-vendor-m-e-p-t-p-application 
        :applicationID="$application->id" 
        :vendorID="$application->vendor_id"
        />
    </div>
</div>
</div>
</div>
@endsection