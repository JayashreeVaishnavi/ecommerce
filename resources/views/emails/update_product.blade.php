@component('mail::message')
    # Update Product

    Please update product quantity.

    @component('mail::button', ['url' => $url])
        Update
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
