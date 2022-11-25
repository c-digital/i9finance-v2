@extends('layouts.shop')

@section('content')

        <style>
            .dropdown:hover > .dropdown-menu {
              display: block;
            }

            @media (max-width: 600px) {
                .logo-container {
                    text-align: center;
                }

                .company-info-container {
                    text-align: center;
                    margin-top: 30px;
                }

                .header-container {
                    margin-top: 100px;
                    margin-bottom: -80px;
                }
            }

            @media (min-width: 600px) {
                .logo-container {
                    text-align: right;
                    margin: auto;
                }
            }
        </style>    

    <div class="row" style="text-align: center;">
        <div class="col header-container">
            <img class="img-fluid" src="{{ '/storage/shops/banners/' . $ecommerce->banner }}" alt="">            
        </div>
    </div>

    <div class="row" style="margin-top: 100px">
        <div class="col logo-container">
            <img style="border: 1px solid black; border-radius: 150px; width: 200px" src="{{ '/storage/shops/logos/' . $ecommerce->logo }}" alt="">
        </div>

        <div class="col company-info-container">
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
            <form class="mt-5">
                <table width="100%">
                    <tr>
                        <td width="10%">
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bars"></i>
                              </a>

                              <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                    <li>
                                        <form>
                                            <a data-id="{{ $category->id }}" class="dropdown-item filter-by-category" href="#">{{ $category->name }}</a>
                                        </form>
                                    </li>
                                @endforeach
                              </ul>
                            </div>
                        </td>

                        <td width="79%">
                            <input type="text" name="search" required class="form-control" value="{{ $request->search }}" placeholder="Ingrese el nombre del producto que desea buscar...">
                        </td>

                        <td width="15%">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> 
                                Buscar
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
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

                                            <input type="hidden" name="parameters" value="{{ $product->variation_id ? json_encode($product->variation_id) : null }}">

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

    <div class="modal" id="parameters-modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <form action="" class="add-to-order-with-parameters">
              <div class="modal-header">
                <h5 class="modal-title">Establecer parámetros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-shopping-cart"></i> Agregar al pedido
                </button>
              </div>
            </form>
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
                <div class="order-details text-center">
                    <h4>No has agregado ningún producto</h4>
                </div>

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

            <div class="modal-body">
                
            </div>
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

            $('.add-to-order-with-parameters').submit(function (event) {
                event.preventDefault();

                quantity = $(this).find('[name=quantity]').val();
                id_product = $(this).find('[name=id_product]').val();
                parameters = $(this).find('[name=parameters]').val();
                prices = [];

                $('.optionRadio:checked').each(function (key, value) {
                    price = $(value).attr('data-price');
                    name = $(value).val();

                    prices[id_product] = { "name": name, "price": price };
                });

                $('[name=prices]').val(JSON.stringify(prices));

                data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    data: {
                        data: data,
                        _token: '{{ csrf_token() }}',
                    },
                    url: '/shop/order',
                    success: function (response) {
                        toastr.options.onclick = function () {
                            $('#view-order').modal('show');
                        }

                        toastr.success('Producto agregado al pedido', 'Click aquí para ver el pedido');

                        $('.order-details').html(response);
                        $('#parameters-modal').modal('hide');
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
                parameters = $(this).find('[name=parameters]').val();

                if (parameters) {
                    $.ajax({
                        type: 'GET',
                        data: {
                            quantity: quantity,
                            parameters: parameters,
                            id_product: id_product
                        },
                        url: '/shop/parameters',
                        success: function (response) {
                            $('#parameters-modal').find('.modal-body').html(response);
                            $('#parameters-modal').modal('show');

                            console.log(response);
                        },
                        error: function (error) {
                            console.log(error.responseText);
                        }
                    });

                    return false;
                }

                data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    data: {
                        data: data,
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
                });
            });

            $('.toggle-categories').click(function () {
                hasClass = $('.categories').hasClass('d-none');

                if (hasClass) {
                    $('.categories').removeClass('d-none');
                } else {
                    $('.categories').addClass('d-none');
                }
            });

            $('.filter-by-category').click(function (event) {
                event.preventDefault();

                id_category = $(this).attr('data-id');
                window.location.href = '?category=' + id_category;
            });
        });

        function eliminarProducto(id) {
            alert(id);
        }
    </script>
@endsection