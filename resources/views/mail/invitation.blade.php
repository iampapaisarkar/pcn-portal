@component('mail::message')
# Invitation as User on {{env('APP_NAME')}}

@if($data['state'])
<h2>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, <br> {{env('APP_NAME')}} has sent you an invitation as a {{$data['role']['role']}} role for {{$data['state']}} state.</h2>
@else
<h2>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, <br> {{env('APP_NAME')}} has sent you an invitation as a {{$data['role']['role']}} role.</h2>
@endif

<h2>Please activate the account by clicking on the link below</h2>
<a target="_blank" href="{{$data['activation_url']}}" rel="noopener">{{$data['activation_url']}}</a>

{{ config('app.name') }}
@endcomponent