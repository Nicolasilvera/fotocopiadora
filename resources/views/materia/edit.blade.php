@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12 offset-md-3 col-md-6">
      <h1 class="w-100 text-primary"><u>EDICIÓN DE MATERIA</u><br></h1>   
      <h2 class="text-secondary"><u>{{$materia->nombre}}</u></h2>
     <br>
      <form action="{{route('materia.update', $materia->nombre)}}" method="POST">
        @method('PATCH')     
        @csrf                                     <!--Token que requiere Laravel -->
        <!--Como se desea que sólo se pueda editar la cantidad de copias, se mantiene hidden esto-->
        <!--En caso de habilitarlo, tener cuidado con UPDATED, activar CASCADE para la referencia en solicitudes. -->
        <br><br><br>
        <div class="form-group" hidden="">
			    <label>Nombre</label>
			    <input type="text" class="form-control" value="<?php echo($materia->nombre);?>" name="nombre" required>
  			</div>
  			<div class="form-group">
  			    <label>Cantidad de copias</label>
  			    <input type="number" class="form-control" value="<?php echo($materia->copias);?>" name="copias" required>
  			</div>
  			<button type="submit" class="btn miBtn miBoton col-12" style="border-color: white;" id="submit">Guardar</button>
      </form>
    </div>
  </div>
</div>
@endsection
