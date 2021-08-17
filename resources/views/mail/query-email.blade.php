@component('mail::message')
# MEPTP - Documents Review Query - {{env('APP_NAME')}}

Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},
There was an issue found in the documentation you provided for the application submitted.

{{$data['application']['query']}}

Kindly log in into you profile to check and make correctionsThank you.

Thank you.


{{ config('app.name') }}
@endcomponent