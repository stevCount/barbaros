Formulario para subir un nuevo archivo

<form action="{{ route('subir') }}" method="GET" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="submit">
</form>
