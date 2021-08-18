@component('mail::message')
# MEPTP Application Approval - {{env('APP_NAME')}}

<div>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}, <br>
CONGRATULATIONS.
</div>

<div>There is to inform you that your application for the MEPTP at the {{$data['application']['school']['name']}} has been approved</div>
<div>Vendor Name: {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}}</div>

<div>Vendor Name: Vendor NamBatch: {{$data['application']['batch']['batch_no']}}</div>
<div>Batch: batch NumbeTier: {{$data['application']['tier']['name']}}</div>
<div>Tier: Tier TypFurther information will be communicated to you accordingly.</div>
<div>Further information will be communicated to you according.</div>
<div>Thank you.</div>

{{ config('app.name') }}
@endcomponent