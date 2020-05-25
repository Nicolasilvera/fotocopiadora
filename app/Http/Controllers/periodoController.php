<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Periodo;
use App\Solicitud;

class periodoController extends Controller
{
    public function index(Request $request)
    {  
        $periodos=DB::table('periodos')->orderBy('periodo','desc')->get();
        return view('periodo.index',['periodos'=>$periodos]);
    }

    public function create(){
        return view('periodo.create');
    }

    public function store(Request $request){
        $periodo=new Periodo();
        $periodo->periodo=request('periodo');
        $periodo->copiasAsignadas=request('copiasAsignadas');
        $periodo->finSolicitud=request('finSolicitud');
        $periodo->inicioBeca=request('inicioBeca');
        $periodo->finBeca=request('finBeca');
        $periodo->fechaRevision=request('fechaRevision');
        $periodo->responsables=request('responsables');
        try { 
            $periodo->save();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
       return redirect('/periodo');
    }


    public function edit($id)
    {
        return view('periodo.edit', ['periodo' =>Periodo::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $periodo= Periodo::findOrFail($id);
        $periodo->copiasAsignadas=$request->get('copiasAsignadas');
        $periodo->finSolicitud=$request->get('finSolicitud');
        $periodo->inicioBeca=$request->get('inicioBeca');
        $periodo->finBeca=$request->get('finBeca');
        $periodo->fechaRevision=$request->get('fechaRevision');
        $periodo->responsables=$request->get('responsables');
        try { 
            $periodo->update();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
        return redirect('/periodo');
    }

    public function show($id) {
        return view('periodo.show', ['periodo' =>Periodo::findOrFail($id)]);
    }

    public function destroy($id){
        DB::table('solicituds')->where('periodo',$id)->delete();
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();
        return redirect('/periodo');
    }

}