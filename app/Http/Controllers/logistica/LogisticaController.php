<?php

namespace App\Http\Controllers\logistica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//paginador
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Barryvdh\DomPDF\Facade as PDF;
//modelos
use App\Modelos\parte_semanal;
use App\Modelos\asignacion_vehiculo;

class LogisticaController extends Controller
{
    protected function getMensaje($mensaje,$destino,$desicion){
        if (!$desicion) {
            alert()->error('Error',$mensaje);
            return  redirect()->route($destino);
        }else{
            alert()->success( $mensaje);
            return  redirect()->route($destino);  
        }

    }

	protected function paginar($datos){

    	 $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Armamos la coleccion con los datos
        $collection = collect($datos);
 
        // definimos cuantos items por magina se mostraran
        $por_pagina = 10;
 
        //armamos el paginador... sin el resolvecurrentpage arma la paginacion pero no mueve el selector
        $datos= new LengthAwarePaginator(
            $collection->forPage(Paginator::resolveCurrentPage() , $por_pagina),
            $collection->count(), $por_pagina,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
        return $datos;
	}


	public function index(Request $Request){

        if (Auth::User()->primer_logeo == null) {
            return redirect('primerIngreso');
        }

        if (strpos(Auth::User()->roles,'Suspendido')) {
            Auth::logout();
            alert()->error('Su usuario se encuentra suspendido');
             return redirect('/login');
        }

		if (($Request->desde && $Request->hasta) != null) {
			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->whereBetween('parte_semanal.created_at',[$Request->desde.' 00:00:00',$Request->hasta.' 23:59:59'])
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.modelo','parte_semanal.created_at','parte_semanal.observaciones_parte','users.nombre','vehiculos.dominio','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else if($Request->desde != null && $Request->Hasta == null){
			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->whereBetween('parte_semanal.created_at',[$Request->desde.' 00:00:00',date("Y-m-d 23:59:59")])
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.numero_de_identificacion','parte_semanal.created_at','parte_semanal.observaciones_parte','users.nombre','vehiculos.dominio','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else if($Request->vehiculoBuscado != null && ($Request->desde && $Request->hasta) == null){
			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->where('vehiculos.numero_de_identificacion',$Request->vehiculoBuscado)
                                            ->orwhere('vehiculos.dominio',$Request->vehiculoBuscado)
                                            ->select('dependencias.nombre_dependencia','nombre.marca','vehiculos.numero_de_identificacion','parte_semanal.created_at','parte_semanal.observaciones_parte','users.usuario','vehiculos.dominio','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else{
			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.numero_de_identificacion','parte_semanal.created_at','parte_semanal.observaciones_parte','users.nombre','vehiculos.dominio','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}

		//return $parteSemanal;
        $parteSemanal = $this->paginar($parteSemanal);
		return view('logistica.parte-semanal',compact('parteSemanal'));
	}

	public function nuevoParte(Request $Request){

        $Validar = \Validator::make($Request->all(), [
            
            'id_vehiculo' => 'required',
            'observaciones'    => 'required'
        ]);
        if ($Validar->fails()){
            alert()->error('Error','ERROR! Intente agregar nuevamente...');
            return  back()->withInput()->withErrors($Validar->errors());
        }

      

        if (count($afectadoSiniestro = asignacion_vehiculo::where('id_vehiculo','=',$Request->id_vehiculo)->get()) == 0) {
        	 return $this->getMensaje('Vehiculo sin asignar','idexParteSemanal',false);
        }else{
        	 $dependenciaAfectada =  asignacion_vehiculo::where('id_vehiculo','=',$Request->id_vehiculo)->get();
	        $nuevoParte = new parte_semanal;

	        $nuevoParte->id_vehiculo = $Request->id_vehiculo;
	        $nuevoParte->id_dependencia = $dependenciaAfectada[0]->id_dependencia;
	        $nuevoParte->observaciones_parte = $Request->observaciones;
	        $nuevoParte->id_usuario = Auth()->User()->id;

        }

        
        if ($nuevoParte->save()) {
            return $this->getMensaje('Cargado con exito','idexParteSemanal',true);
        }else{
            return $this->getMensaje('Error, Intente nuevamente...','idexParteSemanal',false);
        }
	}

	public function editarParte(Request $Request){

        $Validar = \Validator::make($Request->all(), [
            'observaciones_parte'    => 'required'
        ]);
        if ($Validar->fails()){
            alert()->error('Error','ERROR! Intente agregar nuevamente...');
            return  back()->withInput()->withErrors($Validar->errors());
        }

        $nuevoParte =parte_semanal::findorfail($Request->id_parte_semanal);

        $nuevoParte->observaciones_parte = $Request->observaciones_parte;

        if ($nuevoParte->update()) {
            return $this->getMensaje('Editado con exito','idexParteSemanal',true);
        }else{
            return $this->getMensaje('Error, Intente nuevamente...','idexParteSemanal',false);
        }
	}

	public function eliminarParte(Request $Request){

        $Validar = \Validator::make($Request->all(), [
            'id_parte_semanal_baja'    => 'required'
        ]);
        if ($Validar->fails()){
            alert()->error('Error','ERROR! Intente agregar nuevamente...');
            return  back()->withInput()->withErrors($Validar->errors());
        }

		$parteEliminado =parte_semanal::findorfail($Request->id_parte_semanal_baja);

	
        if ($parteEliminado->Delete()) {
            return $this->getMensaje('Eliminado con exito','idexParteSemanal',true);
        }else{
            return $this->getMensaje('Error, Intente nuevamente...','idexParteSemanal',false);
        }

	}

	public function descargaPDFParte($desde,$hasta,$vehiculo){

		if ($vehiculo != 0 and $desde == 0 && $hasta ==0 ) {

			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->where('vehiculos.numero_de_identificacion',$vehiculo)
                                            ->orwhere('vehiculos.dominio',$vehiculo)
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.numero_de_identificacion','parte_semanal.created_at','parte_semanal.observaciones_parte','users.usuario','vehiculos.dominio','vehiculos.numero_de_inventario','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal','users.nombre')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else if(($desde && $hasta) != 0 && $vehiculo == 0){

			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->whereBetween('parte_semanal.created_at',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.numero_de_identificacion','vehiculos.modelo','parte_semanal.created_at','parte_semanal.observaciones_parte','vehiculos.dominio','vehiculos.numero_de_inventario','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal','users.nombre')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else if(($desde && $hasta && $vehiculo) != 0){

			$parteSemanal = parte_semanal::join('dependencias','dependencias.id_dependencia','=','parte_semanal.id_dependencia')
                                            ->join('vehiculos','vehiculos.id_vehiculo','=','parte_semanal.id_vehiculo')
                                            ->join('users','users.id','=','parte_semanal.id_usuario')
                                            ->whereBetween('parte_semanal.created_at',[$desde.' 00:00:00',$hasta.' 23:59:59'])
                                            ->where('vehiculos.numero_de_identificacion',$vehiculo)
                                            ->orwhere('vehiculos.dominio',$vehiculo)
                                            ->select('dependencias.nombre_dependencia','vehiculos.marca','vehiculos.numero_de_identificacion','vehiculos.modelo','parte_semanal.created_at','parte_semanal.observaciones_parte','vehiculos.dominio','vehiculos.numero_de_inventario','vehiculos.id_vehiculo','parte_semanal.id_parte_semanal','users.nombre')
                                            ->orderBy('parte_semanal.id_parte_semanal','desc')
                                            ->get();
		}else if(($desde && $hasta && $vehiculo) == 0){
			return $this->getMensaje('Para poder imprimir debe seleccionar alguna fecha o algun vehiculo','idexParteSemanal',false);
		}

	
	
		$pdf = PDF::loadView('logistica.pdf_parte_semanal', compact('parteSemanal'));

        return $pdf->stream('Lista de novedades'.'.pdf');
	}
}
