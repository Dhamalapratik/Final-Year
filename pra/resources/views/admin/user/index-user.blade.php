@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h1>User</h1>
        @if (session('message'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Successfull",
                    text: "{{ session('message') }}",
                });
            </script>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="" class="btn btn-primary">View</a>
                            <a href="{{ route('admin.delete.user', ['id' => $user->id] ) }}"><button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</button></a>
                            {{-- <form action="{{ route('admin.delete.user ', ['id' => $user->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
