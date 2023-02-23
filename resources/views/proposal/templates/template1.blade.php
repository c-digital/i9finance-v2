<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Propuesta</title>
</head>
<body>
	<div id="element-to-print">
		<div style="padding-left: 30px; padding-right: 30px">

			@php
				$img = str_replace(['i9finance.com', 'http'], ['dev.i9finance.com', 'https'], $img);
				$type = pathinfo($img, PATHINFO_EXTENSION);
				$img = file_get_contents($img);
				$img = 'data:image/' . $type . ';base64,' . base64_encode($img);
			@endphp


			<table width="100%">

				<tr>
					<td valign="center" width="39%">
						<img width="50%" src="{{ $img }}" alt="">
					</td>

					<td valign="center" width="39%">
						<h1>{{ __('COTIZACION') }}</h1>
					</td>
				</tr>

				<tr>
					<td style="padding-top: 100px" valign="top" width="39%">
						@if($settings['company_name'])<b>{{$settings['company_name']}}</b><br>@endif
						@if($settings['company_telephone']){{$settings['company_telephone']}}<br>@endif
                        @if($settings['company_address']){{$settings['company_address']}}@endif
                        @if($settings['company_city']) <br> {{$settings['company_city']}}, @endif @if($settings['company_state']){{$settings['company_state']}}@endif @if($settings['company_zipcode']) - {{$settings['company_zipcode']}}@endif
                    	@if($settings['company_country']) <br>{{$settings['company_country']}}@endif
                        @if(!empty($settings['registration_number'])){{__('Registration Number')}} : {{$settings['registration_number']}}<br> @endif
                    	@if(!empty($settings['tax_type']) && !empty($settings['vat_number'])){{$settings['tax_type'].' '. __('Number')}} : {{$settings['vat_number']}} <br>@endif
					</td>

					<td style="padding-top: 100px" valign="top" width="39%">
						<b>Para:</b><br>
						@if($customer->name)<b>{{$customer->name}}</b><br>@endif
						@if($customer->billing_phone){{$customer->billing_phone}}<br>@endif
						@if($customer->billing_address){{$customer->billing_address}}<br>@endif
						@if($customer->billing_zip){{$customer->billing_zip}}<br>@endif
						@if($customer->billing_city){{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?$customer->billing_state:'',', '}} {{!empty($customer->billing_country)?$customer->billing_country:''}}@endif
					</td>

					<td style="padding-top: 100px" valign="top" widht="10%">
						{!! DNS2D::getBarcodeHTML( route('proposal.link.copy',Crypt::encrypt($proposal->proposal_id)), "QRCODE",2,2) !!}
					</td>
				</tr>
			</table>

			<table style="margin-top: 30px" width="100%">
				<tr>
					<td style="font-size: 20px">{{ Utility::proposalNumberFormat($settings,$proposal->proposal_id) }}</td>
				</tr>

				<tr>
					<td style="font-size: 20px">Fecha: {{ Utility::dateFormat($settings,$proposal->created_at) }}</td>
				</tr>

				<tr>
					<td style="font-size: 20px">Valida hasta: {{ Utility::dateFormat($settings,$proposal->issue_date) }}</td>
				</tr>
			</table>

			<table width="100%">
				<thead>
					<tr style="background-color: silver">
						<th align="left" style="padding: 10px; color: white">{{__('Item')}}</th>
						<th align="right" style="padding: 10px; color: white">{{__('Quantity')}}</th>
						<th align="right" style="padding: 10px; color: white">{{__('Rate')}}</th>
						<th align="right" style="padding: 10px; color: white">{{__('Tax')}} (%)</th>
						<th align="right" style="padding: 10px; color: white">{{__('Discount')}}</th>
						<th align="right" style="padding: 10px; color: white">{{__('Total')}}</th>
					</tr>
				</thead>

				<tbody>
					@if(isset($proposal->itemData) && count($proposal->itemData) > 0)
						@foreach($proposal->itemData as $key => $item)
							<tr>
								<td style="font-size: 12px; padding: 10px">
									<b>{{$item->name}}</b><br>
									{{ $item->description }}
								</td>
								<td style="padding: 10px" align="right">{{$item->quantity}}</td>
								<td style="padding: 10px" align="right">{{Utility::priceFormat($settings,$item->price)}}</td>
								<td style="padding: 10px" align="right">
									@if(!empty($item->itemTax))
                                        @foreach($item->itemTax as $taxes)
                                            <span>{{$taxes['name']}}</span>  <span>({{$taxes['rate']}})</span> <span>{{$taxes['price']}}</span>
                                        @endforeach
                                    @else
                                        <span>-</span>
                                    @endif
								</td>
								<td style="padding: 10px" align="right">{{($item->discount!=0)? Utility::priceFormat($settings,$item->discount):'-'}}</td>
								<td style="padding: 10px" align="right">{{Utility::priceFormat($settings,$item->price * $item->quantity)}}</td>
							</tr>
						@endforeach
					@endif
				</tbody>

				<tfooter>
					<tr>
						<th style="padding: 10px" align="left">{{__('Total')}}</th>
						<th style="padding: 10px" align="right">{{$proposal->totalQuantity}}</th>
						<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->totalRate)}}</th>
						<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->totalTaxPrice) }}</th>
						<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->totalDiscount)}}</th>
						<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->getSubTotal())}}</th>
					</tr>

					@if($proposal->getTotalDiscount())
						<tr>
							<th style="padding: 10px" align="left">{{__('Discount')}}</th>
							<th colspan="4"></th>
							<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->getTotalDiscount())}}</th>
						</tr>		
					@endif

					@if(!empty($proposal->taxesData))
						@foreach($proposal->taxesData as $taxName => $taxPrice)
							<tr>
								<th style="padding: 10px" align="left">{{$taxName}}</th>
								<th colspan="4"></th>
								<th style="padding: 10px" align="right">{{ Utility::priceFormat($settings,$taxPrice)  }}</th>
							</tr>
						@endforeach
					@endif

					<tr>
						<th style="padding: 10px" align="left">{{__('Total')}}</th>
						<th colspan="4"></th>
						<th style="padding: 10px" align="right">{{Utility::priceFormat($settings,$proposal->getSubTotal()-$proposal->getTotalDiscount()+$proposal->getTotalTax())}}</th>
					</tr>
				</tfooter>
			</table>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
		element = document.getElementById('element-to-print');

		options = {
			image: { type: 'png', quality: 0.20 },
            html2canvas: { scale: 2,useCORS: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'p' }
		}

		html2pdf().set(options)
			.from(element)
			.save('propuesta.pdf');
	</script>
</body>
</html>