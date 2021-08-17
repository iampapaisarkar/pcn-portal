@component('mail::message')
# PPMV Licence Application Query - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</h2>
<h2>The result of the Inspection carried out on your location was</h2>
<h2>NOT RECOMMENDED If you wish to apply again, kindly log in into you profile to submit a fresh application.</h2>
<h2>If you wish to apply again, kindly log in into you profile to submit a fresh applicatioThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent