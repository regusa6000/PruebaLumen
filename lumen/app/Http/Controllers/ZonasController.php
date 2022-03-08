<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;


    class ZonasController extends Controller{

        function cargarZonas(){

            $resultado = DB::table('ng_zonas AS zona')
                        ->select('zona.id_zona','zona.nombre_zona','zona.posicion')
                        ->get();

            return response()->json($resultado);
        }

        function cargarLinksPorZonas($idZona){

            $resultado = DB::table('ng_links AS link')
                        ->select('link.*','us.name','zona.nombre_zona')
                        ->join('ng_users AS us','us.id_user','=','link.id_user_add')
                        ->join('ng_zonas AS zona','zona.id_zona','=','link.id_zona')
                        ->where('link.id_zona','=',$idZona)
                        ->orderBy('link.posicion','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function crearNuevaZona(Request $request){

            $nombreZona = $request->input('nombreZona');
            $idUsuario = $request->input('idUsuario');
            $fecha = Carbon::now();
            $posicion = $request->input('posicion');

            $resultado = DB::table('ng_zonas')
                        ->insert([
                            'nombre_zona' => $nombreZona,
                            'id_user_add' => $idUsuario,
                            'fecha_add' => $fecha,
                            'posicion' => $posicion
                        ]);

            return response()->json($resultado);
        }

        function actualizarDatosZona(Request $request){

            $idZona = $request->input('idZona');
            $nombreZona = $request->input('nombreZona');
            $posicion = $request->input('posicion');

            $resultado = DB::table('ng_zonas')
                        ->where('id_zona','=',$idZona)
                        ->update(['nombre_zona' => $nombreZona, 'posicion' => $posicion]);

            return response()->json($resultado);
        }

        function cargarLinks(){

            $resultado = DB::table('ng_links AS link')
                        ->select('link.*','us.name','zona.nombre_zona')
                        ->join('ng_users AS us','us.id_user','=','link.id_user_add')
                        ->join('ng_zonas AS zona','zona.id_zona','=','link.id_zona')
                        ->get();

            return response()->json($resultado);
        }

        function cargarSelectZonas(){

            $resultado = DB::table('ng_zonas AS zona')
                        ->select(DB::raw('DISTINCT(zona.nombre_zona)')
                                ,'zona.id_zona')
                        ->get();

            return response()->json($resultado);
        }

        function crearNuevoLink(Request $request){

            $idUsuario = $request->input('idUsuario');
            $idZona = $request->input('idZona');
            $nombreEnlace = $request->input('nombreEnlace');
            $enlace = $request->input('enlace');
            $formatoEnlace = $request->input('formatoEnlace');
            $fecha = Carbon::now();
            $posicion = $request->input('posicion');

            $resultado = DB::table('ng_links')
                        ->insert([
                            'id_user_add' => $idUsuario,
                            'id_zona' => $idZona,
                            'nombre_link' => $nombreEnlace,
                            'link' => $enlace,
                            'img_icon' => $formatoEnlace,
                            'fecha_add' => $fecha,
                            'posicion' => $posicion
                        ]);

            return response()->json($resultado);
        }

        function actualizarLink(Request $request){

            $idLink = $request->input('idLink');
            $nombreEnlace = $request->input('nombreEnlace');
            $enlace = $request->input('enlace');
            $formatoEnlace = $request->input('formatoEnlace');
            $posicion = $request->input('posicion');

            $resultado = DB::table('ng_links')
                        ->where('id_link','=',$idLink)
                        ->update([
                            'nombre_link' => $nombreEnlace,
                            'link' => $enlace,
                            'img_icon' => $formatoEnlace,
                            'posicion' => $posicion
                        ]);

            return response()->json($resultado);
        }

        function eliminarLink($idLink){

            $resultado = DB::table('ng_links')
                        ->where('id_link','=',$idLink)
                        ->delete();

            return response()->json($resultado);
        }

    }

?>
