@extends('layouts.admin')
@section('page-title')
    {{__('E-Commerce')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('E-Commerce')}}</li>
@endsection


@section('content')
    {{ Form::open(array('url' => 'ecommerce','enctype' => "multipart/form-data")) }}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Información básica</div>

                    <div class="card-body">                    
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group" style="text-align: center">
                                    @if(isset($ecommerce->logo))
                                        <img style="border: 1px solid black; width: 100px; height: 100px; border-radius: 50px" src="{{ '/storage/shops/logos/' . $ecommerce->logo }}" alt="">
                                    @endif

                                    <input type="file" class="form-control mt-1" name="logo">
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="form-group">
                                    <label for="slug">URL</label>

                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">https://i9finance.com/shop/</span>

                                        <input type="text" class="form-control" id="slug" name="slug" required value="{{ $ecommerce->slug ?? null }}">

                                        <button onclick="copyToClipboard(this)" type="button" class="btn btn-secondary">
                                            <i class="fa fa-copy"></i> Copiar
                                        </button>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-2">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" name="name" required value="{{ $ecommerce->name ?? null }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" id="phone" class="form-control" name="phone" required value="{{ $ecommerce->phone ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" class="form-control" name="email" required value="{{ $ecommerce->email ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control" name="address" required value="{{ $ecommerce->address ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Título</label>
                                    <input type="text" class="form-control" name="title" required value="{{ $ecommerce->title ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <input type="text" class="form-control" name="description" required value="{{ $ecommerce->description ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type">Tipo</label>

                                    <select name="type" class="form-control">
                                        <option value=""></option>
                                        <option {{ isset($ecommerce->type) && $ecommerce->type == 'Empresa' ? '' : null }} value="Empresa">Empresa</option>
                                        <option {{ isset($ecommerce->type) && $ecommerce->type == 'Productor' ? '' : null }} value="Productor">Productor</option>
                                        <option {{ isset($ecommerce->type) && $ecommerce->type == 'Distribuidor' ? '' : null }} value="Distribuidor">Distribuidor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type_company">Tipo de empresa</label>

                                    <select name="type" class="form-control">
                                        <option value=""></option>
                                        <option {{ isset($ecommerce->type_company) && $ecommerce->type_company == 'Unipersonal' ? '' : null }} value="Unipersonal">Unipersonal</option>
                                        <option {{ isset($ecommerce->type_company) && $ecommerce->type_company == 'SRL/SA' ? '' : null }} value="SRL/SA">SRL/SA</option>
                                        <option {{ isset($ecommerce->type_company) && $ecommerce->type_company == 'Naturales' ? '' : null }} value="Naturales">Naturales</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nit">NIT</label>
                                    <input type="text" class="form-control" name="nit" value="{{ $ecommerce->nit ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="minimum_order">Pedido mínimo</label>
                                    <input type="text" class="form-control" name="minimum_order" value="{{ $ecommerce->minimum_order ?? null }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Banner
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <input type="file" class="form-control" name="banner">

                                    <div class="mt-3">
                                        @if(isset($ecommerce->banner))
                                            <img class="img-fluid" src="{{ '/storage/shops/banners/' . $ecommerce->banner }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Redes sociales
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="{{ $ecommerce->facebook ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="{{ $ecommerce->instagram ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="google">Google</label>
                                    <input type="text" class="form-control" name="google" value="{{ $ecommerce->google ?? null }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control" name="youtube" value="{{ $ecommerce->youtube ?? null }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="submit" value="Guardar cambios" class="btn btn-primary">
    {{ Form::close() }}

    <input type="hidden" id="slug-hidden">

    <script>
        function copyToClipboard(element) {
            value = document.getElementById('slug').value;
            document.getElementById('slug-hidden').value = 'https://i9finance.com/shop/' + value;
            copyText = document.getElementById('slug-hidden');
            copyText.select();
            document.execCommand("copy");
        }
    </script>    

@endsection



