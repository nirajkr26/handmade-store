<x-mail::message>
# New Message Received

You have received a new message regarding a product on the Handmade Marketplace.

**From:** {{ $msg->sender->name }}
**Message:**
"{{ $msg->message }}"

<x-mail::button :url="route('messages.index')">
Reply Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} team
</x-mail::message>
