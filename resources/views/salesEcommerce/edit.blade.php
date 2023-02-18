@php
	$invoice = $pos;
	$invoice_number = $pos->id;
    $subtotal = $discount = $tax = 0;
@endphp

@extends('layouts.admin')
@section('page-title')
    {{__('Sales Ecommerce edit')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('salesEcommerce.index')}}">{{__('Sales Ecommerce')}}</a></li>
    <li class="breadcrumb-item">{{__('Sales ecommerce Edit')}}</li>
@endsection
@push('script-page')
    <script>
        
        function loadData(that) {
            item = $(that);
            tr = item.parent().parent();

            $.ajax({
                type: 'GET',
                url: '/products/loadData',
                data: {
                    id: item.val()
                },
                success: function (response) {
                    tr.find('.quantity').val(1);
                    tr.find('.price').val(response.sale_price);
                    tr.find('.pro_description').val(response.description);
                    tr.find('.amount').html(response.sale_price);
                },
                error: function (error) {
                    console.log(error.responseText);
                }
            })
        }

        function calculate()
        {
            tr = $(this).parent().parent();

            quantity = tr.find('.quantity');
            price = tr.find('.price');

            console.log(quantity, price);

            amount = parseFloat(price) * parseFloat(quantity);

            tr.find('.amount').html(amount);
        }

        $(document).ready(function () {
            $('.add-item').click(function () {
                $('.ui-sortable').append(`
                    <tr>
                        <td width="25%" class="form-group pt-0">
                            {{ Form::select('item[]', $product_services, null, array('onchange' => 'loadData(this)', 'class' => 'form-control item select','data-url'=>route('invoice.product'))) }}

                            {{ Form::textarea('description', null, ['class'=>'form-control pro_description','rows'=>'2','placeholder'=>__('Description')]) }}
                        </td>
                        <td>

                            <div class="form-group price-input input-group search-form">
                                {{ Form::text('quantity[]',null, array('onchange' => 'calculate()', 'class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required')) }}
                                <span class="unit input-group-text bg-transparent"></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form">
                                {{ Form::text('price[]',null, array('onchange' => 'calculate()', 'class' => 'form-control price','required'=>'required','placeholder'=>__('Price'),'required'=>'required')) }}
                                <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="input-group colorpickerinput">
                                    <div class="taxes">0.00</div>
                                    {{ Form::hidden('tax','', array('class' => 'form-control tax')) }}
                                    {{ Form::hidden('itemTaxPrice','', array('class' => 'form-control itemTaxPrice')) }}
                                    {{ Form::hidden('itemTaxRate','', array('class' => 'form-control itemTaxRate')) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form">
                                {{ Form::text('discount[]','0.00', array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Discount'))) }}
                                <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
                            </div>
                        </td>
                        <td class="text-end amount">0.00</td>

                        <td>
                            @can('delete invoice product')
                                <a href="#" class="ti ti-trash text-white text-danger delete_item" data-repeater-delete></a>
                            @endcan
                        </td>
                    </tr>
                `)
            });
        });

    </script>
@endpush
@section('content')
    {{--    @dd($invoice)--}}
    <div class="row">
        {{ Form::model($invoice, array('route' => array('salesEcommerce.update', $invoice->id), 'method' => 'PUT','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="customer-box">
                                {{ Form::label('customer_id', __('Customer'),['class'=>'form-label']) }}
                                {{ Form::select('customer_id', $customers,null, array('class' => 'form-control select ','id'=>'customer','data-url'=>route('invoice.customer'),'required'=>'required')) }}
                            </div>
                            <div id="customer_detail" class="d-none">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('pos_date', __('Date'),['class'=>'form-label']) }}
                                        <div class="form-icon-user">
                                            {{Form::date('pos_date',$pos->pos_date,array('class'=>'form-control','required'=>'required'))}}


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('invoice_number', __('Pos Number'),['class'=>'form-label']) }}
                                        <div class="form-icon-user">
                                            <input type="text" class="form-control" value="{{$invoice_number}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h5 class=" d-inline-block mb-4">{{__('Product & Services')}}</h5>
            <div class="card repeater" data-value='{!! json_encode($invoice->items) !!}'>
                <div class="item-section py-2">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box me-2">
                                <button type="button" class="btn btn-primary add-item">
                                    <i class="ti ti-plus"></i> {{__('Add item')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                            <thead>
                            <tr>
                                <th>{{__('Items')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Price')}} </th>
                                <th>{{__('Tax')}}</th>
                                <th>{{__('Discount')}}</th>
                                <th class="text-end">{{__('Amount')}} </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="ui-sortable">

                            	@php
                            		$posElements = App\Models\PosProduct::where('pos_id', $pos->id)->get();
                            	@endphp

                            	@foreach($posElements as $item)
		                            <tr>
		                                <td width="25%" class="form-group pt-0">
		                                    {{ Form::select('item[]', $product_services, $item->product_id, array('class' => 'form-control item select','data-url'=>route('invoice.product'))) }}
		                                </td>
		                                <td>

		                                    <div class="form-group price-input input-group search-form">
		                                        {{ Form::text('quantity[]',$item->quantity, array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required')) }}
		                                        <span class="unit input-group-text bg-transparent"></span>
		                                    </div>
		                                </td>
		                                <td>
		                                    <div class="form-group price-input input-group search-form">
		                                        {{ Form::text('price[]',$item->price, array('class' => 'form-control price','required'=>'required','placeholder'=>__('Price'),'required'=>'required')) }}
		                                        <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
		                                    </div>
		                                </td>
		                                <td>
		                                    <div class="form-group">
		                                        <div class="input-group colorpickerinput">
		                                            <div class="taxes">{{$item->tax}}</div>
		                                            {{ Form::hidden('tax','', array('class' => 'form-control tax')) }}
		                                            {{ Form::hidden('itemTaxPrice','', array('class' => 'form-control itemTaxPrice')) }}
		                                            {{ Form::hidden('itemTaxRate','', array('class' => 'form-control itemTaxRate')) }}
		                                        </div>
		                                    </div>
		                                </td>
		                                <td>
		                                    <div class="form-group price-input input-group search-form">
		                                        {{ Form::text('discount[]',$item->discount, array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Discount'))) }}
		                                        <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
		                                    </div>
		                                </td>
		                                <td class="text-end amount">{{number_format($item->price+$item->tax-$item->discount,2)}}</td>

		                                <td>
		                                    @can('delete invoice product')
		                                        <a href="#" class="ti ti-trash text-white text-danger delete_item" data-repeater-delete></a>
		                                    @endcan
		                                </td>
		                            </tr>
		                            <tr>
		                                <td colspan="2">
		                                    <div class="form-group">
		                                        {{ Form::textarea('description[]', $item->description ?? \App\Models\ProductService::find($item->product_id)->description, ['class'=>'form-control pro_description','rows'=>'2','placeholder'=>__('Description')]) }}
		                                    </div>
		                                </td>
		                                <td colspan="5"></td>
		                            </tr>

                                    @php
                                        $subtotal = $subtotal + $item->price;
                                        $discount = $discount + $item->discount;
                                        $tax = $tax + $item->tax;
                                    @endphp
	                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td><strong>{{__('Sub Total')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-end subTotal">{{number_format($subtotal, 2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td><strong>{{__('Discount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-end totalDiscount">{{number_format($discount, 2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td><strong>{{__('Tax')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-end totalTax">{{number_format($tax, 2)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="blue-text"><strong>{{__('Total Amount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-end totalAmount blue-text">{{number_format($subtotal+$tax-$discount, 2)}}</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("invoice.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection

