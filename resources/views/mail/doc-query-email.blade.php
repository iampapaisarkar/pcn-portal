@component('mail::message')
# Licence Registration Document Review Query - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</h2>
<h2>There was an issue found in the documentation you provided for the PPMV Licence Registration.</h2>
<h2>Kindly log in into you profile to check and make correctionsThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent