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
				$total_pedido = 0;
				$total_productos = 0;
			@endphp

			@foreach($order as $key => $quantity)

				@php
					$product = App\Models\ProductService::find($key);
					$total_pedido = $total_pedido + ($product->sale_price * $quantity);
					$total_productos = $total_productos + $quantity;
				@endphp

				<tr>
					<th>{{ $product->name }}</th>
					<th>{{ $quantity }}</th>
					<th>{{ $product->sale_price }}</th>
					<th>{{ number_format($quantity * $product->sale_price, 2) }}</th>
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
				<td>{{ $total_pedido }}</td>
			</tr>

			<tr>
				<th>Total productos</th>
				<td>{{ $total_productos }}</td>
			</tr>
		</tbody>
	</table>
</div>