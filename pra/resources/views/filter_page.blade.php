


  @extends('layouts.main')

  @section('content')
  @foreach($products as $product)

      <!-- desktop site__header / end --><!-- site__body -->
      <div class="card" style="width: 18rem;">
        <img src="{{ asset('productimages/'.$product->image)}}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">{{ $product ->name}}</h5>
          <p class="card-text">{{$product->description}}</p>
          {{-- <p class="card-text">{{$product->price}}</p> --}}
        <a href="#" class="btn btn-primary">{{$product->price}}</a>
        </div>
      </div>

    @endforeach

  @endsection
