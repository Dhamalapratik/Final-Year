@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>
        <hr>
        @if (session('message'))
            <div class='alert alert-default-success' id="time">
                {{ session('message') }}
            </div>
        @endif
        <form action="{{ route('admin.update.category', ['id' => $category->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"  required>{{ $category->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
    </div>
@endsection

@section('script')
@endsection
