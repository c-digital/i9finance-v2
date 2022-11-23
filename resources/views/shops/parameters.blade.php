<div>
	<input type="hidden" name="id_product" value="{{ $id_product }}">
	<input type="hidden" name="quantity" value="{{ $quantity }}">

	@foreach($parameters as $parameter)
		<div class="form-group">
			<label for="{{ $parameter->name }}">{{ $parameter->name }}</label>
			<select name="parameters[{{ $parameter->name }}]" id="{{ $parameter->name }}" required class="form-control">
				<option value=""></option>

				@foreach(explode(',', $parameter->options) as $option)
					<option value="{{ $option }}">{{ $option }}</option>
				@endforeach
			</select>
		</div>
	@endforeach
</div>