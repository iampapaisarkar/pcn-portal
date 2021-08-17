@component('mail::message')
# Payment Successfully Done {{env('APP_NAME')}}

@if($data['type'] == 'meptp_training')
<h2>Hello {{Auth:user()->firstname}} {{Auth:user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN MANDATORY ENTRY POINT TRAINING PROGRAMME (MEPTP) FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS).
</h2>
<h2>Kindly log in to the portal to view status and application progress.</h2>
<h2>Thank you.</h2>
@endif


@if($data['type'] == 'ppmv_registration')
<h2>Hello {{Auth:user()->firstname}} {{Auth:user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN LICENCE REGISTRATION FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) for the year {{$data['year']}}.
</h2>

<h2>Kindly log in to the portal to view status and application progress.</h2>

<h2>Thank you.</h2>
@endif



@if($data['type'] == 'ppmv_renewal')
<h2>Hello {{Auth:user()->firstname}} {{Auth:user()->lastname}}, <br>
This is to acknowledge your application and payment of the sum of N{{$data['amount']}} being made for PCN LICENCE REGISTRATION FOR PATENT AND PROPRIETARY MEDICINE VENDORS (PPMVS) for the year {{$data['year']}}.
</h2>

<h2>Kindly log in to the portal to view status and application progress.</h2>

<h2>Thank you.</h2>
@endif

{{ config('app.name') }}
@endcomponent