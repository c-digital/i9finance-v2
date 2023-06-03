<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            -webkit-print-color-adjust:exact !important;
            print-color-adjust:exact !important;
            margin: 10px;
            font-size: 13px;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        th, td {
            padding: 0.5rem 0.5rem;
        }

        th {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="d-flex justify-content-between">
            <div>
                <img src="{{$img}}" style="max-width: 150px"/>

                <div class="row mt-5">
                    <div class="font-weight-bold">FACTURA {{Utility::invoiceNumberFormat($settings,$invoice->invoice_id)}}</div>
                    <div>Fecha: {{Utility::dateFormat($settings,$invoice->issue_date)}}</div>
                </div>
            </div>

            <div>
                {!! DNS2D::getBarcodeHTML( route('proposal.link.copy', Crypt::encrypt($invoice->invoice_id)), "QRCODE",2,2) !!}                
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="font-weight-bold">@if($settings['company_name']){{$settings['company_name']}}@endif</div>
                <div>@if($settings['company_address']){{$settings['company_address']}}@endif</div>
                <div>@if($settings['company_telephone']){{$settings['company_telephone']}}@endif</div>
                <div>@if($settings['company_city']){{$settings['company_city']}}@endif @if($settings['company_state']){{$settings['company_state']}}@endif</div>
                <div>@if($settings['company_country']){{$settings['company_country']}}@endif @if($settings['company_zipcode']){{$settings['company_zipcode']}}@endif</div>
            </div>

            <div class="col text-right">
                <div>
                    <div class="font-weight-bold">Para:</div>
                    <div>{{!empty($customer->billing_name)?$customer->billing_name:''}}</div>
                    <div>{{!empty($customer->billing_phone)?$customer->billing_phone:''}}</div>
                    <div>{{!empty($customer->billing_address)?$customer->billing_address:''}}</div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <table>
                <thead>
                    <tr style="background-color: {{ $color }}">
                        <th>#</th>
                        <th>{{__('Item')}}</th>
                        <th class="text-right">{{__('Quantity')}}</th>
                        <th class="text-right">{{__('Rate')}}</th>
                        <th class="text-right">{{__('Tax')}}</th>
                        <th class="text-right">{{__('Discount')}}</th>
                        <th class="text-right">
                            <div>{{__('Price')}}</div>
                            <small>({{__('before tax & discount')}})</small>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @php $i = 1; @endphp
                    @foreach($invoice->itemData as $key => $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td nowrap>
                                <div>{{$item->name}}</div>
                                <small>{{$item->description}}</small>
                            </td>
                            <td class="text-right">{{$item->quantity}}</td>
                            <td class="text-right">{{ Utility::priceFormat($settings,$item->price) }}</td>
                            <td class="text-right">
                                @if(!empty($item->itemTax))
                                    @foreach($item->itemTax as $taxes)
                                        <div>{{ $taxes['name'] }} ({{ $taxes['rate']}}) {{$taxes['price'] }}</div>
                                    @endforeach
                                @else
                                   <span>-</span>
                                @endif
                            </td>
                            <td class="text-right">{{($item->discount!=0)?Utility::priceFormat($settings,$item->discount):'-'}}</td>
                            <td class="text-right">{{Utility::priceFormat($settings,$item->price * $item->quantity)}}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot style="border-top: 1px solid silver">
                    <tr>
                        <td colspan="5"></td>
                        <th class="text-right">{{ __('Discount') }}</th>
                        <td class="text-right">{{ Utility::priceFormat($settings,$invoice->getTotalDiscount()) }}</td>
                    </tr>

                    @foreach($invoice->taxesData as $taxName => $taxPrice)
                        <tr>
                            <td colspan="5"></td>
                            <th class="text-right">{{ $taxName }}</th>
                            <td class="text-right">{{ Utility::priceFormat($settings,$taxPrice) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="5"></td>
                        <th class="text-right">{{__('Total')}}</th>
                        <td class="text-right">{{ Utility::priceFormat($settings,$invoice->getSubTotal()-$invoice->getTotalDiscount()+$invoice->getTotalTax()) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if(!isset($preview))
        @include('invoice.script');
    @endif
</body>
</html>