@component('mail::message')

<h1>Hi,</h1>

You have recieved a refferal invitation from <strong>{{ auth()->user()->full_name }}</strong> from {{ config('app.name') }}.

Below is the refferal link.

<strong>{{ url('/register') . '?ref=' . encrypt(auth()->user()->id) }}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent