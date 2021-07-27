@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Result', 'route' => 'meptp-application-result'])
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
                @if($application->status == 'rejected')
                <div class="col-md-12">
                    <div class="alert alert-card alert-danger" role="alert">
                    Sorry! You were unsuccessful in the MEPTP Training Examination (Batch: 1/2021)
                    <button class="btn btn-rounded btn-danger ml-3">Download Result</button>
                    </div>
                </div>
                @endif
                @if($application->status == 'approved_card_generated')
                <div class="col-md-12">
                    <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">Congratulation! You were successful in the MEPTP Training Examination (Batch: 1/2021)
                        <button class="btn btn-rounded btn-success ml-3">Download Result</button>
                    </div>
                    </div>
                </div>
                @endif
            </div>
        @else
        <span>No application found!</span>
        @endif
        </div>
        <x-vendor-m-e-p-t-p-application/>

    </div>
</div>
@endsection