@extends('layouts.app')
@section('content')

<!--  ESTA SECCIÓN DE SHOW, mostrará todos los certificados disponibles para el período seleccionado -->
  <h1 id="titulo" class="w-100 text-primary" style="text-align: center; font-family: serif;"></h1>
  <h1 id="tituloHidden" hidden>{{$periodo->periodo}}</h1>

  <div class="row">
    <div class="card col-5" style="position:relative; height: 50vh; overflow: hidden;">
        <center style="height: 87%; overflow-y: scroll; overflow-x: hidden;">
          <img src="{{asset('img\reglamento.png')}}" alt="...">
        </center>
        <a href="reglamento/{{$periodo->periodo}}" class="btn btn-primary">Reglamento</a>
    </div>
    <div class="card offset-1 col-5" style="position:relative; height: 50vh; overflow: hidden;">
        <center style="height: 87%; overflow-y: scroll; overflow-x: hidden;">
          <img src="{{asset('img\Cartel.png')}}" alt="...">
        </center>
        <a href="cartel/{{$periodo->periodo}}" class="btn btn-primary">Cartel</a>
    </div>
    <div class="card col-5" style="position:relative; height: 50vh; overflow: hidden;">
        <center style="height: 87%; overflow-y: scroll; overflow-x: hidden;">
          <img src="{{asset('img\solicitud.png')}}" alt="...">
        </center>
        <a href="solicitud/{{$periodo->periodo}}" class="btn btn-primary">Solicitud</a>
    </div>
    <div class="card offset-1 col-5" style="position:relative; height: 50vh; overflow: hidden;">
        <center style="height: 87%; overflow-y: scroll; overflow-x: hidden;">
          <img src="{{asset('img\planilla.png')}}" alt="...">
        </center>
        <a href="{{asset('periodo/planillas/'.$periodo->periodo)}}" class="btn btn-primary"> Planillas Iniciales</a>
    </div>
    <div class="card col-5" style="position:relative; height: 50vh; overflow: hidden;">
        <center style="height: 87%; overflow-y: scroll; overflow-x: hidden;">
          <img class="w-100" src="{{asset('img\copiasCorregidas.png')}}" alt="...">
        </center>
        <a href="{{asset('periodo/copiasCorregidas/'.$periodo->periodo)}}" class="btn btn-primary"> Planilla de Revisión</a>
    </div>



  </div>
  <script type="text/javascript">
  $(document).ready(function(){
    $partePeriodo=$("#tituloHidden").html().split('-');
    $("#titulo").html("Documentación del "+$partePeriodo[1] + " del año " +$partePeriodo[0]);
  });   
</script>
@endsection