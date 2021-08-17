@component('mail::message')
# MEPTP - Examination Result - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</h2>
<h2>This is to notify you that your Examination Result for just concluded PCN MANDATORY ENTRY POINT TRAINING PROGRAMME (MEPTP) FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) has been uploaded.</h2>
<h2>Kindly log in into the portal with your profile details to view and print.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent