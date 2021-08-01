@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Renewals', 'route' => 'ppmv-renewal'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h2 class=" mb-6">Renewals</h2>
                <a href="{{route('renew-licence')}}"><button class="btn btn-primary" type="button">RENEW LICENCE</button></a>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Vendor Name</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                            <tr>
                                <td>{{$renewal->description}}</td>
                                <td>{{$renewal->description}}</td>
                                <td>{{$renewal->description}}</td>
                                <td>{{$renewal->description}}</td>
                                <td>{{$renewal->description}}</td>
                                <td> <p><span class="rounded badge w-badge badge-success">
                                        Updated {{$renewal->updated_at->format('d-M-Y')}}
                                    </span></p></td>
                                <td><a href="#"><button class="btn btn-info btn-icon btn-sm m-0" type="button"> <span class="ul-btn__icon"><i class="i-Gear-2"></i></span> <span class="ul-btn__text">LICENCE</span></button></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection