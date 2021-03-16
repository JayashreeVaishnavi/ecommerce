@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2>Add Product</h2>
            </div>
            <div class="col-lg-4">
                <a class="btn btn-primary float-right" href="{{ url('products') }}" title="Create a product">Cancel</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('products') }}" method="POST">
            @csrf
            @include('products.common_fields')
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
