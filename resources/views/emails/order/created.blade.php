<x-mail::message>
# Your order (#{{ $order->id }}) has been placed

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
