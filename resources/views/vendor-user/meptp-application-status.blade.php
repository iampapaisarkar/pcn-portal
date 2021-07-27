@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Status', 'route' => 'meptp-application-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
        @if($application)
            <h4>MEPTP Application Status - Vendor Details</h4>
            <div class="row">

                @if($application->status == 'pending')
                <div class="col-md-12">
                    <div class="alert alert-card alert-warning" role="alert">APPLICATION FOR MEPTP (Batch: {{$application->batch->batch_no .'/'. $application->batch->year}})
                        STATUS: Document Verification Pending</div>
                </div>
                @endif
                @if($application->status == 'queried')
                <div class="col-md-12">
                    <div class="alert alert-card alert-danger" role="alert">
                        <p>APPLICATION FOR MEPTP (Batch: {{$application->batch->batch_no .'/'. $application->batch->year}}) STATUS: Document Verification Queried</p>
                        <p><strong>REASONS: </strong></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean feugiat, nulla ut dictum
                            varius, arcu libero interdum quam, vel ullamcorper odio est vitae lacus.</p>
                    </div>
                </div>
                @endif
                @if($application->status == 'approved')
                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: {{$application->batch->batch_no .'/'. $application->batch->year}})
                        STATUS: Application Approved</div>
                </div>
                @endif
                @if($application->status == 'approved_card_generated')
                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: {{$application->batch->batch_no .'/'. $application->batch->year}})
                        STATUS: Application Approved and Examination Card Generated
                        <button class="btn btn-rounded btn-success ml-3">Download Examination Card</button>
                    </div>
                </div>
                @endif
            </div>

            <x-vendor-m-e-p-t-p-application/>
        @else
        <span>No application found!</span>
        @endif
        </div>

    </div>
</div>
@endsection