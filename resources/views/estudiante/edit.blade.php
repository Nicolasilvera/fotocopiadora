@extends('layouts.app')

@section('content')
<div class="container col-sm-12 offset-md-3 col-md-6">
    <br>
    <h1 class="w-100 text-primary">   <u>EDICIÓN DE ESTUDIANTE</u>    </h1>  
    <h2 class="text-cyan"><i>DNI:</i>    {{$estudiante->nombre}} {{$estudiante->apellido}} </h2>
    <br>
    <form action="{{route('estudiante.update', $estudiante->dni)}}" method="POST">
      @method('PATCH')     
      @csrf                                     <!--Token que requiere Laravel -->

      <!--Como se desea que sólo se pueda editar Nombre y Apellido, se mantiene hidden esto-->
        <!--En caso de habilitarlo, tener cuidado con UPDATED, activar CASCADE para la referencia en solicitudes. -->
      <div class="form-group" hidden="">
          <label>DNI</label>
          <input type="text" class="form-control" value="<?php echo($estudiante->dni);?>" name="dni" required>
      </div>
      <div class="form-group">
          <label>Apellido</label>
          <input type="text" class="form-control" value="<?php echo($estudiante->apellido);?>" name="apellido" required>
      </div>
      <div class="form-group">
			    <label>Nombre</label>
			    <input type="text" class="form-control" value="<?php echo($estudiante->nombre);?>" name="nombre" required>
			</div>
		  <button type="submit" class="btn miBtn miBoton col-12" style="border-color:white;" id="submit">Guardar</button>
    </form>
</div>
@endsection
