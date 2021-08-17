@component('mail::message')
# MEPTP - Examination Information - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</h2>
<h2>This is to notify you that your MEPTP Index Number and Examination Card have been successfully generated.</h2>
<h2>Kindly log in into the portal with your profile details to print your examination cardThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent