<div>
	<input type="hidden" name="id_product" value="{{ $id_product }}">

	@foreach($parameters as $parameter)
		<div class="form-group">
			<label for="{{ $parameter->name }}">{{ $parameter->name }}</label>
			<select name="{{ $parameter->name }}" id="{{ $parameter->name }}" class="form-control">
				@foreach(explode(',', $parameter->parameters) as $option)
					<option value="{{ $option }}">{{ $option }}</option>
				@endforeach
			</select>
		</div>
	@endforeach
</div>