@component('mail::message')
# Approve MEPTP Traning Application {{env('APP_NAME')}}

<h2>MEPTP Traning Application approved & selected for Tier</h2>
<h2>Vendor Name: {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}</h2>
<h2>Batch: {{$data['application']['batch']['batch_no']}}/{{$data['application']['batch']['year']}}</h2>
<h2>Tier: {{$data['application']['tier']['name']}}</h2>

{{ config('app.name') }}
@endcomponent