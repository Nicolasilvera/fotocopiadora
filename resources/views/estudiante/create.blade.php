@extends('layouts.app')
@section('content')
<div class="container">
	  <br>
	  <h1 class="w-100 text-primary"><u>DATOS DEL ESTUDIANTE</u></h1>
	  <br>
	  <div class="row">
	     <form action="/estudiante" method="POST" class="offset-3 col-6">
	        @csrf   <!--Token que requiere Laravel -->
	        <!--Todo el formulario. name debe coincidir con el campo de la BD y método POST*-->
	        <div class="form-group">
			    <label>DNI</label>
			    <input type="number" class="form-control" name="dni" required>
			</div>
	       	<div class="form-group">
			    <label>Apellido</label>
			    <input type="text" class="form-control" name="apellido" required>
			</div>
			<div class="form-group">
			    <label>Nombre</label>
			    <input type="text" class="form-control" name="nombre" required>
			</div>
			 <button type="submit" class="btn miBtn miBoton col-12" style="border-color: white;" id="submit">CARGAR ESTUDIANTE</button>
	     </form>
	  </div>
</div>

@endsection
