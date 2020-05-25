@extends('layouts.app')

@section('content')
<br>
<center class="text-primary">
  <h3>SOLICITUDES DE</h3>
  <h3>{{$periodo->periodo}}</h3>
</center>
<div class="row">
    <div class="col-6">
      <a href="{{route('solicitud.create', $periodo->periodo)}}"><button  type="button" class="btn miBtn miBoton" style="border-color:#28324D;"><i class="fas fa-notes-medical"></i> NUEVA SOLICITUD</button></a>
      <a href="{{asset('revision/'.$periodo->periodo)}}"><button  type="button" class="btn miBtn miBtnGreen" style="border-color: #28324D; color:white"><i class="fas fa-tasks"></i> REVISIÓN</button></a>
      <a href="{{route('periodo.show', $periodo->periodo)}}" ><button type="button" class="btn miBtn miBtnDanger" style="border-color: #28324D; color:white" title="Imprimir documentación"><i class="far fa-file-pdf"></i> Imprimir Documentación</button></a>
    </div>
    <div class="col-6">
      <p style="float: right;">
        <b>Copias otorgadas por fotocopiadora: </b>{{$periodo->copiasAsignadas}}
      </p>
    </div>
</div>
<br>
<table class="table table-hover" style="text-align: center;">
  <thead>
    <tr>
      <th scope="col">Estudiante</th>
      <th scope="col">Lista de Materias</th>
      <th scope="col">Copias Otorgadas</th>
      <th scope="col">Categoría</th>
      <th scope="col">Copias Usadas</th>
      <th scope="col">Copias Corregidas</th>
      <th scope="col">Editar/Eliminar</th>
    </tr>
  </thead>
  <tbody>
      @foreach($solicituds as $solicitud)
        <tr>
          <td>{{$solicitud->estudiante}}</td>
          <td>
            <?php
              $listaMaterias = explode(';', $solicitud->listaMaterias);
              foreach ($listaMaterias as $l){
                  echo($l."<br>");
              }
            ?>
          </td>
          <td>{{$solicitud->copiasOtorgadas}}</td>
          <td>{{$solicitud->categoria}}</td>
          <td>{{$solicitud->copiasUsadas}}</td>
          <td>{{$solicitud->copiasCorregidas}}</td>
          <td>
              <form action="{{route('solicitud.destroy', $solicitud->id)}}" class="row" method="POST">
                <a href="{{route('solicitud.edit', $solicitud->id)}}" class="col-5"><button type="button" class="btn miBtn miBtnGreen"><i class="fas fa-pencil-alt"></i></button></a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn miBtn miBtnDanger offset-1 col-5"><i class="fas fa-trash-alt"></i></button>
              </form>
          </td>
        </tr>
      @endforeach
  </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function(){
    //Desconcatenar los responsables para mostrarlos en una lista 
    $(".TDresponsables").each(function(){
      var conc="";
      var responsable= $(this).html().split('-');
      for(var i=0; i < responsable.length; i++){
        if(responsable[i]!=''){
          conc=conc+responsable[i]+"<br>"; 
        }
      }
     $(this).html(conc);
    });
  });   
</script>

@endsection