@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HTML-CSS-CRUD</title>
  <!--==================== UNICONS ====================-->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
  
  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"/>

  @vite(['resources/css/app.css'])

</head>

<body>
    <main class="container">
        <section>
            <div class="titlebar">
                <h1>Products</h1>
                <a href="{{ route('products.create')}}" style="color: aliceblue">Add Products</a>
            </div>
                @if ($message = Session::get('success'))
                 <script type="text/javascript">
                    const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: "success",
  title: '{{ $message }}'
});
                 </script>
                @endif
            <div class="table">
                <div class="table-filter">
                    <div>
                        <ul class="table-filter-list">
                            <li>
                                <p class="table-filter-link link-active">All</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <form method="GET" action="{{ route('products.index') }}" accept-charset="UTF-8" role="search">
                <div class="table-search">   
                    <div>
                        <button class="search-select">
                           Search Product
                        </button>
                        <span class="search-select-arrow">
                            <i class="fas fa-caret-down"></i>
                        </span>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Search product..." value="{{ request('search') }}">
                    </div>
                </div>
            </form>
                <div class="table-product-head">
                    <p>Image</p>
                    <p>Name</p>
                    <p>Category</p>
                    <p>Inventory</p>
                    <p>Actions</p>
                </div>
                <div class="table-product-body">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                        <img src="{{ asset('images/' . $product->image)}}"/>
                        <p>{{ $product->name}}</p>
                        <p>{{ $product->category}}</p>
                        <p>{{ $product->quantity}}</p>
                        <div style="display: flex">     
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-link" style="padding-top: 4px;padding-bottom:4px;margin-right:2px" >
                                <i class="fas fa-pencil-alt" ></i> 
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                @method('delete')
                                @csrf
            <button class="btn btn-danger " onclick="form.submit();" >
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    @else
                    <p>No products found</p>
                    @endif
                </div>
                <div class="table-paginate">
                    {{ $products->links('layouts.pagination') }}
                </div>
            </div>
        </section>
        <br>
    </main>  
</body>
</html>
@endsection