<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Producto</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>Total</th>
				<th></th>
			</tr>		
		</thead>

		<tbody>

			@php
				$total_order = 0;
				$total_products = 0;
			@endphp

			@foreach($order as $key => $quantity)

				@php
					$product = App\Models\ProductService::find($key);

					$total_order = $total_order + ($product->sale_price * $quantity);
					$total_products = $total_products + $quantity;			
				@endphp

				<tr>
					<th>
						{{ $product->name }}

						@if(isset($parameters[$key]))

							@php $additional = 0; @endphp

							<div>
								<small>|
									@foreach($parameters[$key] as $key => $value)

										@php
											$price = null;

											if (isset($prices[$product->id])) {
												$i = array_search($value, array_column(json_decode($prices[$product->id], true), 'name'));
												$price = json_decode($prices[$product->id], true)[$i]['price'];
												$additional = $additional + $price;
											}
										@endphp

										{{ $key . ': ' . $value }} @if($price)(+ Bs. {{ $price }}) |@endif
									@endforeach
								</small>
							</div>
						@endif
					</th>

					<th>{{ $quantity }}</th>

					<th>{{ $additional ? number_format($product->sale_price + $additional, 2) : number_format($product->sale_price, 2) }}</th>

					<th>{{ $additional ? number_format($quantity * ($product->sale_price + $additional), 2) : number_format(($quantity * $product->sale_price), 2) }}</th>

					<td>
						<button type="button" class="btn btn-danger" title="Eliminar" onclick="eliminarProducto({{ $key }})">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<hr>

	<table class="table">
		<tbody>
			<tr>
				<th>Total pedido</th>
				<td>{{ number_format($total_order, 2) }}</td>
			</tr>

			<tr>
				<th>Total productos</th>
				<td>{{ $total_products }}</td>
			</tr>
		</tbody>
	</table>
</div>