<div>
	<input type="hidden" name="id_product" value="{{ $id_product }}">
	<input type="hidden" name="quantity" value="{{ $quantity }}">
	<input type="hidden" name="prices">

	@foreach($parameters as $parameter)
		<div class="form-group">
			<label for="{{ Str::slug($parameter->name) }}">{{ $parameter->name }}</label>

			<div>
				@foreach($parameter->options as $option)
					<label style="margin-right: 10px" for="{{ Str::slug($option['name']) }}">
						<input
							class="optionRadio"
							data-price="{{ $option['price'] }}"
							required
							type="radio"
							name="parameters[{{ Str::slug($parameter->name) }}]"
							id="{{ Str::slug($option['name']) }}"
							value="{{ Str::slug($option['name']) }}"
						> 

						{{ $option['name'] }} @if($option['price'])(+ Bs. {{ $option['price'] }})@endif
					</label>
				@endforeach
			</div>
		</div>
	@endforeach
</div>