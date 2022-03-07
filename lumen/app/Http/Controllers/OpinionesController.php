<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;

    class OpinionesController extends Controller{

        function listadoCanales(){

            $resultado = DB::table('ng_opinionesTipo AS tipo')
                        ->select('tipo.id', 'tipo.canal')
                        ->get();

            return response()->json($resultado);
        }

        function listadoGeneral(){

            $resultado = DB::table('ng_opinionesTipo AS tipo')
                        ->select('tipo.id AS idCanal','val.id AS idValor'
                                ,'tipo.canal','tipo.base','val.fecha'
                                ,DB::raw('ROUND(val.porcentaje,2) AS porcentaje')
                                ,DB::raw('ROUND(val.valor,2) AS valor'))
                        ->join('ng_opinionesValores AS val','val.idOpinionesTipo','=','tipo.id')
                        ->orderBy('val.fecha','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function baseTipoOpinion($id){

            $resultado = DB::table('ng_opinionesTipo AS tipo')
                        ->select('tipo.base')
                        ->where('tipo.id','=',$id)
                        ->get();

            return $resultado;
        }

        function registrarPorcentaje(Request $request){

            $idCanal = $request->input('idCanal');
            $valor = $request->input('valor');
            $porcentaje = $request->input('porcentaje');
            $fecha = Carbon::now();

            $resultado = DB::table('ng_opinionesValores')
                        ->insert([
                            'idOpinionesTipo' => $idCanal,
                            'valor' => $valor,
                            'porcentaje' => $porcentaje,
                            'fecha' => $fecha
                        ]);

            return response()->json($resultado);
        }

        function actualizarPorcentaje(Request $request){

            $idOpinionesValores = $request->input('idValor');
            $valor = $request->input('valor');
            $porcentaje = $request->input('porcentaje');

            $resultado = DB::table('ng_opinionesValores')
                        ->where('id','=',$idOpinionesValores)
                        ->update(['valor' => $valor , 'porcentaje' => $porcentaje]);

            return response()->json($resultado);
        }

        function eliminarPorcentaje($idOpinionesTipo){

            $resultado = DB::table('ng_opinionesValores')
                        ->where('idOpinionesTipo','=',$idOpinionesTipo)
                        ->delete();

            return response()->json($resultado);
        }

        function rellenarSelect(){

            $resultado = DB::table('ng_opinionesTipo AS opt')
                        ->select('opt.id','opt.canal')
                        ->get();

            return response()->json($resultado);
        }

        function cargarGrafico($id){

            $resultado = DB::table('ng_opinionesValores AS val')
                        ->select('*')
                        ->where('val.idOpinionesTipo','=',$id)
                        ->orderBy('val.fecha','ASC')
                        ->get();

            return response()->json($resultado);
        }

    }

?>
