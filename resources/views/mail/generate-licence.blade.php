@component('mail::message')
# PPMV Licence Approval - {{env('APP_NAME')}}

<h2>Hello {{$vendor['firstname']}} {{$vendor['lastname']}},</h2>
<h2>There is to notify you that your Licence for the year {{$data['renewal_year']}} has been approved.</h2>
<h2>Attached with this email is a copy of your licence or log in into you profile to downloadThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent