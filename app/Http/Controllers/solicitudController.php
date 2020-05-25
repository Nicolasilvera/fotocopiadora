<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Solicitud;
use App\Periodo;

class solicitudController extends Controller
{
    
    public function index(Request $request)
    {
    	$periodoString=str_replace("_", " ", explode("=",explode("?", url()->full())[1])[0]);
        $periodo= Periodo::where('periodo', $periodoString)->get()[0];
        $solicituds=Solicitud::where('periodo', $periodoString)->get();
        $sumaCopiasTotales=0;
        $copiasPeriodo=$periodo->copiasAsignadas;

        foreach ($solicituds as $solicitud){
            $sumaCopiasTotales+=$solicitud->copiasTotales;
        }

        if($sumaCopiasTotales != 0){
            $multiplicador = $copiasPeriodo/$sumaCopiasTotales;
        }else{
            $multiplicador=0;
        }
        

        foreach ($solicituds as $solicitud){
            $solicitud->copiasOtorgadas= floor($solicitud->copiasTotales * $multiplicador);
            try { 
                $solicitud->update();
            } catch(\Illuminate\Database\QueryException $ex){        
            }
        }

        return view('solicitud.index',['solicituds'=>$solicituds , 'periodo'=>Periodo::findOrFail($periodoString)]);
            //return view('solicitud.index',['solicituds'=>$solicituds, 'periodo' =>Periodo::findOrFail($periodo)]);
    }

    public function create(){
    	$periodo=str_replace("_", " ", explode("=",explode("?", url()->full())[1])[0]);
        return view('solicitud.create',['periodo' =>Periodo::findOrFail($periodo)]);
    }

    public function store(Request $request){
        $solicitud=new Solicitud();
        $solicitud->periodo=request('periodo');
        $solicitud->estudiante=request('estudiante');
        $solicitud->listaMaterias=request('listaMaterias');
        $solicitud->copiasTotales=request('copiasTotales');
        try { 
            $solicitud->save();
        } catch(\Illuminate\Database\QueryException $ex){ 
                 
        }
    	return redirect('/solicitud?'.$solicitud->periodo);
    }

    public function edit($id)
    {
        return view('solicitud.edit', ['solicitud' =>Solicitud::findOrFail($id)]);
    }

    public function update(Request $request, $id){
        $solicitud= Solicitud::findOrFail($id);
        if( null !== $request->get('listaMaterias')){
            $solicitud->listaMaterias=$request->get('listaMaterias');
        }

        if( null !== $request->get('copasUsadas')){
            $solicitud->copiasUsadas=$request->get('copiasUsadas');
        }
        
        try { 
            $solicitud->update();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
        return redirect('/solicitud?'.$solicitud->periodo);
    }
/*
    public function show($id) {
        return view('solicitud.show', ['solicitud' =>Solicitud::findOrFail($id)]);
    }
    */
    public function destroy($id){
        $solicitud = Solicitud::findOrFail($id);
        $periodo= $solicitud->periodo;
        $solicitud->delete();
        return redirect('/solicitud?'.$periodo);
    }

     public function calcularCopiasIniciales(){
        $periodoString=str_replace("%20", " ", explode("=",explode("/calcularCopiasIniciales/", url()->full())[1])[0]);
        $periodo= Periodo::firstOrFail('periodo', $periodoString)->get()[0];
        $solicituds=Solicitud::where('periodo', $periodoString)->get();
        $sumaCopiasTotales=0;
        $copiasPeriodo=$periodo->copiasAsignadas;

        foreach ($solicituds as $solicitud){
            $sumaCopiasTotales+=$solicitud->copiasTotales;
        }

        $multiplicador = $copiasPeriodo/$sumaCopiasTotales;

        foreach ($solicituds as $solicitud){
            $solicitud->copiasOtorgadas= floor($solicitud->copiasTotales * $multiplicador);
            try { 
                $solicitud->update();
            } catch(\Illuminate\Database\QueryException $ex){        
            }
        }

        return view('solicitud.index',['solicituds'=>$solicituds , 'periodo'=>Periodo::findOrFail($periodoString)]);
    }

    public function revision(){
        $periodoString=str_replace("%20", " ",explode("/revision/", url()->full())[1]);
        $periodo= Periodo::firstOrFail('periodo', $periodoString)->get()[0];
        $solicituds=Solicitud::where('periodo', $periodoString)->get();
        return view('solicitud.ingresarUsadas',['solicituds'=>$solicituds , 'periodo'=>Periodo::findOrFail($periodoString)]);

    }

    public function editarCopiasUsadas(){
        //Cada solicitud está representada por el id de la solicitud y la cantidad de copias que usó el alumno correspondiente a esa solicitud. Por lo tanto la cantidad de solicitudes corresponde sólo a la mitad de elementos que vienen dados en el get.
        $cantSolicitudes = (sizeof($_POST) - 1)/2;              //Le resto un campo, que es el $_POST['token']
        $cantCatA = 0;
        $copiasTotalesCatA = 0;
        $quitadas = 0;

        for($i=0; $i < $cantSolicitudes; $i++){
            $solicitud= Solicitud::findOrFail($_POST['id'.$i]);
            $solicitud->copiasUsadas= $_POST['copiasUsadas'.$i];

            $entregadas= $solicitud->copiasOtorgadas;
            $usadas =  $_POST['copiasUsadas'.$i];

            if($usadas == 0){
                $solicitud->categoria = 'C';
                $solicitud->copiasCorregidas = 0;
                $quitadas+=$entregadas;
            }else if( $usadas < ($entregadas/2) ){
                $solicitud->categoria = 'B';
                $solicitud->copiasCorregidas = floor( ($entregadas - $usadas) * 0.2);
                $quitadas+=($entregadas - $usadas - $solicitud->copiasCorregidas);
            }else{
                $solicitud->categoria= 'A';
                $cantCatA++;
                $copiasTotalesCatA+=$solicitud->copiasTotales;
            }

            try { 
                $solicitud->update();
            } catch(\Illuminate\Database\QueryException $ex){      
            }
        }
        for($i=0; $i < $cantSolicitudes; $i++){
            $solicitud= Solicitud::findOrFail($_POST['id'.$i]);
            
            $multiplicador = $quitadas/$copiasTotalesCatA;

            if( $solicitud->categoria == 'A'){
                $entregadas= $solicitud->copiasOtorgadas;
                $usadas =  $_POST['copiasUsadas'.$i];
                $restantes = $entregadas - $usadas;
                $solicitud->copiasCorregidas = $restantes + floor($solicitud->copiasTotales * $multiplicador);
                try { 
                    $solicitud->update();
                } catch(\Illuminate\Database\QueryException $ex){      
                }
            }
        }


        $periodoString=str_replace("%20", " ",explode("/editarCopiasUsadas/", url()->full())[1]);
        $periodo= Periodo::firstOrFail('periodo', $periodoString)->get()[0];
        $solicituds=Solicitud::where('periodo', $periodoString)->get();
        return view('solicitud.index',['solicituds'=>$solicituds , 'periodo'=>Periodo::findOrFail($periodoString)]);
    }
}
