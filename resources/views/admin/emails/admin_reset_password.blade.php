@component('mail::message')
# Reset Account
Welcome {{ $data['data']->name }}


@component('mail::button', ['url' => aurl('reset/password/' . $data['token'])])

  Click Here To Reset Your Password

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
