@component('mail::message')
# MEPTP Application Approval - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}, <br>
CONGRATULATIONS.
</h2>

<h2>There is to inform you that your application for the MEPTP at the {{$data['application']['school']['name']}} has been approvedVendor Name: {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}</h2>

<h2>Vendor Name: Vendor NamBatch: {{$data['application']['batch']['batch_no']}}</h2>
<h2>Batch: batch NumbeTier: {{$data['application']['tier']['name']}}</h2>
<h2>Tier: Tier TypFurther information will be communicated to you accordingly.</h2>
<h2>Further information will be communicated to you accordingThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent