@extends('layouts.app')

@section('content')
    <br>
    <div id="acciones" class="row">
      <div id="botones" class="col-8">
        <a href="{{route('materia.create')}}" ><button type="button" class="btn miBtn miBoton" style="border-color: white;"><i class="fas fa-plus"></i> Nueva Materia</button></a>
      </div> <!--Div Botones-->
      <div class="col-4">
        <input class="form-control campoBusqueda" type="text" style="font-weight: bold" placeholder="Ingrese una búsqueda">
      </div> <!--Div campo búsqueda-->
    </div>
    <br><br>
    <div class="indexTable" style="width: 99%">
    <table class="table table-hover" style="text-align: center;">                         <!--Tabla de materias-->
      <!--Carga dinámica de todas las materias en el sistema-->
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Cantidad de copias</th>
          <th scope="col">Editar/Eliminar</th>
        </tr>
      </thead>
      <tbody>
          @foreach($materias as $materia)
            <tr>
              <td>{{$materia->nombre}}</td>
              <td>{{$materia->copias}}</td>
              <td>
                 <form action="{{route('materia.destroy', $materia->nombre)}}" method="POST">
                    <a href="{{route('materia.edit', $materia->nombre)}}" ><button type="button" class="btn miBtn miBtnGreen"><i class="fas fa-pencil-alt"></i></button></a>
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn miBtn miBtnDanger"><i class="fas fa-trash-alt"></i></button>
                  </form>

              </td>
            </tr>
          @endforeach
      </tbody>
    </table>                                                                        <!--Cierra tabla de materias-->

    <!--DIV para mostrar el mensaje de "No se encuentran resultados"-->
    <center class="notFound" > 
    </center>

    </div>            <!--Cierra el DIV de indexTable-->



  <script type="text/javascript">
    $(document).ready(function(){

      //Traigo todos las materias de la BD a una variable de js llamada 'materias'
      materias=[];
      <?php 
        $materias=DB::table('materias')->orderBy('nombre')->get();
        foreach ($materias as $materia){
          print("materia=['".$materia->nombre."',".$materia->copias."];");
          print("materias.push(materia);");
        }
      ?>

      //PROCEDIMIENTO DE BÚSQUEDA
      $( ".campoBusqueda" ).keyup(function() {
          //La variable cadenaBusqueda almacena el valor del campo de búsqueda, mientras que buffer va almacenando la estructura de una tabla de resultados.
          var cadenaBusqueda = $(".campoBusqueda").val().toLowerCase();
          var buffer="";

          for(m in materias){
            //Para cada materia en la BD, tomo el nombre, que será el único criterio que se tendrá en cuenta para la búsqueda
            nombre= materias[m][0].toLowerCase();

            //Luego si la cadena de búsqueda está condenida dentro de una materia. Se considera la materia matchea con la búsqueda. Y se añade al buffer.
            if(nombre.includes(cadenaBusqueda)) {
                buffer+= "<tr>";
                buffer+= "<td>"+materias[m][0]+"</td>";
                buffer+= "<td>"+materias[m][1]+"</td>";
                buffer+= "<td>";
                buffer+= "<form action='borrarMateria/"+materias[m][0]+"' method='GET'>";
                buffer+= "<a href='materia/"+materias[m][0]+"/edit'><button type='button' class='btn miBtn miBtnGreen'><i class='fas fa-pencil-alt'></i></button></a>";
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