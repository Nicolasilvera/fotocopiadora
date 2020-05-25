@extends('layouts.app')
@section('content')

<form class="container row" action="{{asset('editarCopiasUsadas/'.$periodo->periodo)}}" method="POST">
    <center class="text-primary w-100">
      <h1 class="w-100 text-primary">REVISIÓN DE COPIAS</h1>   
      <h2 class="text-secondary">{{$periodo->periodo}}</h2>
    </center>
    <br>
    <br>
    <table class="table table-hover" style="text-align: center">
      <thead>
        <tr>
          <th style="width:50px;">ID</th>
          <th>Apellido y Nombre</th>
          <th>DNI</th>
          <th>Copias Otorgadas</th>
          <th>Copias Usadas</th>
        </tr>
      </thead>      
      <tbody>
          {{ csrf_field() }}
          <?php 
           use App\Estudiante;
           $estudiante = new Estudiante();
           $index = 0;
            foreach ($solicituds as $solicitud) {
              $dniEstudiante = $solicitud->estudiante;
              $estudiante= Estudiante::where('dni', $dniEstudiante)->firstOrFail();
              echo("<tr>");
              echo("<td width:50px;><input style=' background-color:transparent; border:0px; font-weight:bold;' class='bg-transparente' name='id".$index."' value=".$solicitud->id." readonly></input></td>");
              echo("<th>".$estudiante->apellido.", ".$estudiante->nombre."</th>");
              echo("<td id='dni".$index."'>".$solicitud->estudiante."</td>");
              echo("<td>".$solicitud->copiasOtorgadas."</td>");
              echo("<td style='width:15%;'><input type='number' class='form-control' value=".$solicitud->copiasUsadas." name='copiasUsadas".$index."' id='copias".$index."'> </input></td>");
              echo("</tr>");
              $index++;
            }
          ?>
      </tbody>
    </table>
    <button type="submit" class="btn miBoton miBtn col-12" style="border-color: white" id="boton"> Guardar copias usadas </button>
</form>
@endsection
