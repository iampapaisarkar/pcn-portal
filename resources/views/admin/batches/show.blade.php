@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Manage MEPTP Batch', 'route' => 'batches.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">Manage MEPTP Batch</div>
        <form method="POST" action="{{ route('batches.update', $batch->id) }}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
            <label for="picker1">Select the Batch Number and year</label>
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    <select required name="batch_no" class="form-control @error('batch_no') is-invalid @enderror" disabled>
                        <option hidden selected value="">Select Batch Number</option>
                    </select>
                    @error('batch_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-3 form-group mb-3">
                    <select required name="year" class="form-control @error('year') is-invalid @enderror" disabled>
                        <option hidden selected value="">Select Year</option>
                    </select>
                    @error('year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
               
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">CLOSE BATCH</button>
                    <div><span>** log Created By and Closed At</span></div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection