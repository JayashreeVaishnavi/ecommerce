@component('mail::message')
    # Place Order

    Please place your order within an hour for {{ $name }}

    @component('mail::button', ['url' => $url])
        View Order
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
