@extends('admin.layouts.main')

@section('content')

<div class="container">
    @if (session('message'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Category",
                    text: "{{ session('message') }}",
                });
            </script>
        @endif
    <div class="row">
        <div class="col-md-12">
            <h2>Products</h2>
            <a href="{{ route('admin.create.product') }}" class="btn btn-success mb-2">Add Product</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{  route('admin.edit.product', ['id' => $product->id])}}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('admin.delete.product', ['id' => $product->id] ) }}"><button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
