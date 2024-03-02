@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Category</h1>
            </div>
            <div>
                <button><a href="{{ route('admin.add.category') }}">Add Category</a></button>
            </div>
        </div>
        @if (session('message'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Category",
                    text: "{{ session('message') }}",
                });
            </script>
        @endif


        <table class="table table-striped" id="category">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <a href="{{ route('admin.edit.category', ['id' => $category->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('admin.delete.category', ['id' => $category->id] ) }}"><button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</button></a>
                            {{-- <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links('pagination::simple-tailwind') }}

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#category').DataTable();
        });
    </script>
@endsection
