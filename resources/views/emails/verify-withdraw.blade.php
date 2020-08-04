@component('mail::message')
<h1>Hi, {{ auth()->user()->full_name }}</h1>
<br>

Your payment withdraw verification code is {{ auth()->user()->withdraw_two_factor_code }}

@component('mail::button', ['url' => route('user.verify.payment.index', ['amount' => encrypt($amount)])])
Verify Here
@endcomponent

If you have not tried to withdraw, ignore this message.

Thanks,<br>
{{ config('app.name') }}

<hr>

@endcomponent
