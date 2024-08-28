<x-mail::message>
# Reset Password

Please click this Reset Password button to reset your Password.
I will validate only for 30 minutes.

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
