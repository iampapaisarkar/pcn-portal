@component('mail::message')
# MEPTP Application Declined - {{env('APP_NAME')}}

<h2>Hello {{$data['vendor']['firstname']}} {{$data['vendor']['lastname']}},</h2>
<h2>Your application for the MEPTP Training has been declined with the following reason:</h2>
<h2>- {{$data['application']['query']}}</h2>
<h2>If you wish to apply again, kindly log in into you profile to watch out for a new batch in order to apply afreshThank you.</h2>
<h2>Thank you.</h2>

{{ config('app.name') }}
@endcomponent