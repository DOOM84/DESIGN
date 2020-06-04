@component('mail::message')
# Hi,

You have been invited to join team
**{{$invitation->team->name}}**
Because you are not signed up to the platform, please
[Register for free]({{$url}}), then you can access or reject the
invitation in your team management console.


@component('mail::button', ['url' => $url])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
