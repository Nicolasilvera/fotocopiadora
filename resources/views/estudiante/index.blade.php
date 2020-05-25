@extends('layouts.app')

@section('content')
    <br>
    <div id="acciones" class="row">
      <div id="botones" class="col-8">
        <a href="{{route('estudiante.create')}}" ><button type="button" class="btn miBtn miBoton" style="border-color: white"><i class="fas fa-plus"></i> Nuevo Estudiante</button></a>
      </div> <!--Div Botones-->
      <div class="col-4">
        <input class="form-control campoBusqueda" type="text" style="font-weight: bold" placeholder="Ingrese una búsqueda">
      </div> <!--Div campo búsqueda-->
    </div>
    <br><br>
    <div class="indexTable" style="width: 99%">
    <table class="table table-hover" style="text-align: center;">                       <!--Tabla de alumnos-->
      <thead>
        <tr>
          <th>DNI</th>
          <th>Apellido</th>
          <th>Nombre</th>
          <th>Editar / Eliminar</th>
        </tr>
      </thead>
      <!--Carga dinámica de todos los estudiantes registrados en el sistema-->
      <tbody>
          @foreach($estudiantes as $estudiante)
            <tr>
              <td>{{$estudiante->dni}}</td>
              <td>{{$estudiante->apellido}}</td>
              <td>{{$estudiante->nombre}}</td>
              <td>
                <form action="{{route('estudiante.destroy', $estudiante->dni)}}" method="POST">
                  <!--Botón Editar-->
                  <a href="{{route('estudiante.edit', $estudiante->dni)}}" ><button type="button" class="btn miBtn miBtnGreen"><i class="fas fa-pencil-alt"></i></button></a>
                  <!--Token y botón para eliminar con Laravel-->
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn miBtn miBtnDanger"><i class="fas fa-trash-alt"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>                                                                      <!--Cierra tabla de alumnos-->

    <!--DIV para mostrar el mensaje de "No se encuentran resultados"-->
    <center class="notFound" > 
    </center>
    </div>        <!--Cierra el DIV de index table-->





  <script type="text/javascript">
    $(document).ready(function(){
      //Traigo todos los estudiantes de la BD a una variable de js llamada 'estudiantes'
      estudiantes=[];
      <?php 
         $estudiantes=DB::table('estudiantes')->orderBy('apellido')->orderBy('nombre')->get();
        foreach ($estudiantes as $estudiante){
          print("estudiante=[".$estudiante->dni.",'".$estudiante->apellido."','".$estudiante->nombre."'];");
          print("estudiantes.push(estudiante);");
        }
      ?>

      //PROCEDIMIENTO DE BÚSQUEDA
      $( ".campoBusqueda" ).keyup(function() {
          //La variable cadenaBusqueda almacena el valor del campo de búsqueda, mientras que buffer va almacenando la estructura de una tabla de resultados.
          var cadenaBusqueda = $(".campoBusqueda").val().toLowerCase();
          var buffer="";

          for(e in estudiantes){
            //Para cada estudiante en la BD, tomo los valores del dni, apellido, nombre, y distintas combinaciones basadsas en apellido y nombre que frecuentemente se usan para buscar a una persona
            dni= estudiantes[e][0].toString().toLowerCase();
            apellido= estudiantes[e][1].toLowerCase();
            nombre= estudiantes[e][2].toLowerCase();  
            apynom = apellido+" "+nombre;
            apynom2= apellido+", "+nombre;
            nomyap = nombre+" "+apellido;
            nomyap2= nombre+", "+apellido;

            //Luego si la cadena de búsqueda coincide con dni, apellido, nombre o alguna de las combinaciones que acabamos de declarar. Se considera que el alumno matchea con la búsqueda. Y se añade al buffer.
            if(dni.includes(cadenaBusqueda)|| apellido.includes(cadenaBusqueda) || nombre.includes(cadenaBusqueda) || apynom.includes(cadenaBusqueda) || apynom2.includes(cadenaBusqueda) || nomyap.includes(cadenaBusqueda) || nomyap2.includes(cadenaBusqueda)) {
                buffer+= "<tr>";
                buffer+= "<td>"+estudiantes[e][0]+"</td>";
                buffer+= "<td>"+estudiantes[e][1]+"</td>";
                buffer+= "<td>"+estudiantes[e][2]+"</td>";
                buffer+= "<td>";
                buffer+= "<form action='borrarEstudiante/"+estudiantes[e][0]+"' method='GET'>";
                buffer+= "<a href='estudiante/"+estudiantes[e][0]+"/edit'><button type='button' class='btn miBtn miBtnGreen'><i class='fas fa-pencil-alt'></i></button></a>";
                buffer+= " <button type='submit' class='btn miBtn miBtnDanger'><i class='fas fa-trash-alt'></i></button>";
                buffer+= "</form>";
                buffer+= "  </td>";
                buffer+= "</tr>)";
            }
          }

          //Borro los resultados de la búsqueda anterior, y el mensaje de NOT FOUND por las dudas.
          $(".notFound").empty();   
          $("tbody").empty();      
          
          //Si hay resultados, los muestro, si no, muestro el cartel de NOT FOUND.
          if(buffer != ""){
            $("tbody").append(buffer);
          }else{
            $(".notFound").append("<p style='text-align:center; font-size:20px; color:cyan'><i>No hay resultados que coincidan con su búsqueda</i></p> ");
          }
                    
          //Por último, corrijo el css de los tr agregados recientemente.
          $("tr").mouseover(function(){
            $( this ).css( "color", "white" );
          });

      });//FIN PROCEDIMIENTO DE BÚSQUEDA
      
    });//FIN DOCUMENT.READY   
  </script>
@endsection