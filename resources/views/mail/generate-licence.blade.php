@component('mail::message')
# PPMV Licecne Generated Done {{env('APP_NAME')}}

<h2>Year: {{$data['renewal_year']}}</h2>
<h2>Expires At: {{$data['expires_at']}}</h2>

{{ config('app.name') }}
@endcomponent