@extends('admin.layouts.main')

@section('content')

<div class="container">
    <div class="row">
            <div class="col-md-12">
                <h2>Edit Product</h2>
            </div>
        <div class="col-md-8 w-full">
            <div class="">
                <div class="">
                    <form action="{{ route('admin.update.product',['id'=>$product->id ]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"  value="{{ $product->name  }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"  value="{{ $product->description  }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="full_description" class="form-label">Full Description</label>
                            <textarea class="form-control" id="full_description" name="full_description"  value="" required>{{ $product->full_description  }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price"  value="{{ $product->price  }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity"  value="{{ $product->quantity  }}" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Image (Thumbnail)</label>
                            <input type="file" id="image" name="image" class="form-control-file" accept="image/*" >
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category_id" class="form-control"  required>
                                <option value="">Select a category</option>
                                <!-- Loop through categories to populate options -->
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
