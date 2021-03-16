@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card mb-3" style="margin: 0 auto;float: none;margin-bottom: 10px;width: 700px">
                <img class="card-img-top" src="{{ $product->picture }}" height="400px">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Price</strong>: <span>Rs.{{ $product->price }}</span></p>
                    <p class="card-text"><strong>Quantity</strong>: <span>{{ $product->quantity }}</span></p>
                </div>
                <div class="card-footer">
                    <a class="edit btn btn-success btn-sm float-right" onclick="updateOrder({{$product->id}},'place')"
                       style="margin: 2px">Place Order</a>
                    <a class="edit btn btn-warning btn-sm float-right"
                       style="margin: 2px" onclick="updateOrder({{$product->id}},'cart')">Add to cart</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function updateOrder(productId, type) {
            Swal.fire({
                title: "An input!",
                text: "Write something interesting:",
                input: 'text',
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('order') }}" + "/" + productId + "/" + type,
                        type: 'post',
                        data: {
                            quantity: result.value,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.status,
                                icon: 'success',
                            });
                            window.location.href = "{{ url('products') }}";
                        },
                        error: function (data) {
                            let text = data.responseText;
                            Swal.fire({
                                title: 'Error!',
                                text: text.replace(/\"/g, ""),
                                icon: 'error',
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Add Quantity',
                        icon: 'error',
                    })
                }
            });
        }
    </script>
@endsection
