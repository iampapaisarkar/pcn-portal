@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Status', 'route' => 'meptp-application-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">

        <!--begin::form-->


        <div class="card-body">
            <h4>MEPTP Application Status - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-warning" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Document Verification Pending</div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-danger" role="alert">
                        <p>APPLICATION FOR MEPTP (Batch: 1/2021) STATUS: Document Verification Queried</p>
                        <p><strong>REASONS: </strong></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean feugiat, nulla ut dictum
                            varius, arcu libero interdum quam, vel ullamcorper odio est vitae lacus.</p>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Application Approved</div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Application Approved and Examination Card Generated
                        <button class="btn btn-rounded btn-success ml-3">Download Examination Card</button>
                    </div>
                </div>
            </div>

        </div>

        <x-vendor-m-e-p-t-p-application/>

    </div>
    @endsection