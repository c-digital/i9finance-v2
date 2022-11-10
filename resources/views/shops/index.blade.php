@extends('layouts.shop')

@section('content')
    <div class="row" style="margin-top: 100px">
        <div class="col" style="text-align: right; margin: auto">
            <img src="{{ '/storage/shops/logos/' . $ecommerce->logo }}" alt="">
        </div>

        <div class="col">
            <h1>{{ $ecommerce->name }}</h1>

            @if($ecommerce->nit)
                <p>NIT: {{ $ecommerce->nit }}</p>
            @endif

            @if($ecommerce->address)
                <p>Dirección: {{ $ecommerce->address }}</p>
            @endif

            @if($ecommerce->phone)
                <p>Dirección: {{ $ecommerce->phone }}</p>
            @endif

            @if($ecommerce->email)
                <p>Correo electrónico: {{ $ecommerce->email }}</p>
            @endif

            <div>
                @if($ecommerce->facebook)
                    <a style="margin-right: 10px" target="_blank" href="{{ $ecommerce->facebook }}">
                        <i class="fab fa-facebook"></i>
                    </a>
                @endif

                @if($ecommerce->instagram)
                    <a style="margin-right: 10px" target="_blank" href="{{ $ecommerce->instagram }}">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif

                @if($ecommerce->google)
                    <a style="margin-right: 10px" target="_blank" href="{{ $ecommerce->google }}">
                        <i class="fab fa-google"></i>
                    </a>
                @endif

                @if($ecommerce->youtube)
                    <a style="margin-right: 10px" target="_blank" href="{{ $ecommerce->youtube }}">
                        <i class="fab fa-youtube"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col" style="text-align: center;">
            <img class="img-fluid" src="{{ '/storage/shops/banners/' . $ecommerce->banner }}" alt="">

            <form class="mt-5">
                <div class="input-group">
                    <button class="btn btn-secondary toggle-categories" type="button">
                        <i class="fa fa-bars"></i>
                    </button>

                    <input type="text" name="search" required class="form-control" value="{{ $request->search }}" placeholder="Ingrese el nombre del producto que desea buscar...">

                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> 
                        Buscar
                    </button>
                </div>
            </form>

            <div class="mt-5 categories d-none">
                <ul class="list-group">
                    @foreach($categories as $category)
                        <li class="list-group-item">                            

                            <form style="cursor: pointer" class="filter-by-category">
                                <input type="hidden" name="category" value="{{ $category->id }}">

                                @if($request->search)
                                    <input type="hidden" name="search" value="{{ $request->search }}">
                                @endif

                                {{ $category->name }}
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 100px">
        <hr>

        <h3>Productos</h3>

        <div class="col">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="img-fluid" src="{{ '/storage/uploads/pro_image/' . $product->pro_image }}" alt="">
                                
                                {{ $product->name }} <br>

                                Precio: {{ $product->sale_price }} <br>

                                <div class="mt-3">
                                    <form class="add-to-order">
                                        <div class="input-group">
                                            <input type="number" required name="quantity" class="form-control" min="1" placeholder="Ingrese cantidad">

                                            <input type="hidden" name="id_product" value="{{ $product->id }}">

                                            <button type="submit" title="Agregar al pedido" class="btn btn-primary">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal" id="view-order" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="process-order-form" action="/shop/sale" method="POST">

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="slug" value="{{ $slug }}">

              <div class="modal-header">
                <h5 class="modal-title">Pedido</h5>
              </div>
              <div class="modal-body">
                <div class="order-details"></div>

                <div class="customer-details d-none">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <div>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <div>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="proccess-order btn btn-primary">Realizar pedido</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <div class="modal" id="success-order" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pedido</h5>
            </div>

            <div class="modal-body"></div>
        </div>
      </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            proccess = 1;

            $('.proccess-order').click(function () {
                if (proccess == 1) {
                    $('.order-details').addClass('d-none');
                    $('.customer-details').removeClass('d-none');

                    proccess = 0;

                    return false;
                }

                data = $('.process-order-form').serialize();

                console.log(data);

                $.ajax({
                    method: 'POST',
                    url: '/shop/sale',
                    data: data,
                    success: function (response) {
                        $('#view-order').modal('hide');

                        console.log(response);

                        $('#success-order').find('.modal-body').html(response);
                        $('#success-order').modal('show');
                    },
                    error: function (error) {
                        console.log(error.responseText);
                    }
                });
            });

            $('.add-to-order').submit(function (event) {
                event.preventDefault();

                quantity = $(this).find('[name=quantity]').val();
                id_product = $(this).find('[name=id_product]').val();

                $.ajax({
                    type: 'POST',
                    data: {
                        quantity: quantity,
                        id_product: id_product,
                        _token: '{{ csrf_token() }}'
                    },
                    url: '/shop/order',
                    success: function (response) {
                        toastr.options.onclick = function () {
                            $('#view-order').modal('show');
                        }

                        toastr.success('Producto agregado al pedido', 'Click aquí para ver el pedido');

                        $('.order-details').html(response);
                    },
                    error: function (error) {
                        console.log(error.responseText);
                    }
                })
            });

            $('.toggle-categories').click(function () {
                hasClass = $('.categories').hasClass('d-none');

                if (hasClass) {
                    $('.categories').removeClass('d-none');
                } else {
                    $('.categories').addClass('d-none');
                }
            });

            $('.filter-by-category').click(function () {
                $(this).submit();
            });
        });

        function eliminarProducto(id) {
            alert(id);
        }
    </script>
@endsection