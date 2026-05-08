<x-mail::message>
# Order Confirmation

Thank you for your purchase! Your order has been placed successfully.

**Order ID:** #{{ $order->id }}
**Total Amount:** ${{ number_format($order->total_amount, 2) }}
**Shipping to:** {{ $order->shipping_address }}

<x-mail::button :url="route('orders.index')">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} team
</x-mail::message>
