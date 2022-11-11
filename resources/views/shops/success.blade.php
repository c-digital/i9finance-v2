<div class="text-center">
	<div>
		<h1>
			<i class="fa fa-check text-success"></i> ¡Pedido recibido!
		</h1>
	</div>

	<div class="m-5 alert alert-warning">
		<b>ACCIÓN NECESARIA:</b><br>
		Enviar confirmación vía Whatsapp <br><br>

		<a href="https://api.whatsapp.com/send?phone=584246402701&text={{$message}}" target="_blank" class="btn btn-success">
			<i class="fab fa-whatsapp"></i> Enviar
		</a>

		<br>

		<a href="/shop/tracking/{{$pos_id}}" target="_blank" class="btn btn-info m-3">
			Click aquí para ver el estado de la orden
		</a>
	</div>
</div>	