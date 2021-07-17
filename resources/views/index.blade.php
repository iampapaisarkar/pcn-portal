@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Dashboard', 'route' => 'dashboard'])
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- CARD ICON-->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">PASSED</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">Tiered PPMV Registration</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection