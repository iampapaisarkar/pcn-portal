@component('mail::message')
# Payment Successfully Done {{env('APP_NAME')}}

@if($data['type'] == 'meptp_training')
<h2>Your payment has been received successfully for MEPTP Traning Application</h2>
<h2>Order ID {{$data['order_id']}}</h2>
<h2>Batch {{$data['batch']['batch_no']}}/{{$data['batch']['year']}}</h2>
@endif
@if($data['type'] == 'ppmv_registration')
<h2>Your payment has been received successfully for PPMV Registration Application</h2>
<h2>Order ID {{$data['order_id']}}</h2>
@endif
@if($data['type'] == 'ppmv_renewal')
<h2>Your payment has been received successfully for PPMV Licence Renewal</h2>
<h2>Order ID {{$data['order_id']}}</h2>
@endif

{{ config('app.name') }}
@endcomponent