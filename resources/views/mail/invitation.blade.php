@component('mail::message')
# Invitation from {{env('APP_NAME')}}

@if($data['state'])
<h2>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, {{env('APP_NAME')}} has sent you an invitation to the {{$data['role']['role']}} role at {{$data['state']}} state, Please activate the account by clicking on the link below</h2>
@else
<h2>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, {{env('APP_NAME')}} has sent you an invitation to the {{$data['role']['role']}} role, Please activate the account by clicking on the link below</h2>
@endif

<a target="_blank" href="{{$data['activation_url']}}" rel="noopener">{{$data['activation_url']}}</a>

{{ config('app.name') }}
@endcomponent