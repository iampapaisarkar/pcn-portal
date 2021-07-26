@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Invoices', 'route' => 'invoices.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h3>Invoices</h3>
        <hr>
        <div class="table-responsive">
            <!--  id="multicolumn_ordering_table" -->
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice #</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->created_at->format('d-M-Y')}}</td>
                        <td>{{$invoice->order_id}}</td>
                        <td>{{$invoice->service->description}}</td>
                        <td>N{{number_format($invoice->amount)}}</td>
                        @if($invoice->status == true)
                        <td><span class="badge badge-success">Paid</span></td>
                        @else
                        <td><span class="badge badge-warning">Unpaid</span></td>
                        @endif
                        <td><a href="{{route('invoices.show', $invoice->id)}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
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