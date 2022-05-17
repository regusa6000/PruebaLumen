<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Carbon;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;


    class DocumentosController extends Controller{

        function registrarNoticias(Request $request){

            $file = $request->file('archivo');
            $name = $file->getClientOriginalName();

            if(File::exists('noticias/'.$name)){
                return response()->json(false);
            }else{

                if ($request->hasFile('archivo')){
                    $file->move('noticias/',$name);
                }

                $idUser = $request->idUser;
                $titulo = $request->titulo;
                $noticia = $request->noticia;
                $nameImg = $name;
                $fecha = Carbon::now();

                $resultado = DB::table('ng_noticias')->insert([
                    'id_user'=>$idUser,
                    'titulo'=>$titulo,
                    'noticia'=>$noticia,
                    'img'=>$nameImg,
                    'fecha'=>$fecha
                ]);

                return response()->json($resultado);
            }

        }

        function listadoNoticias($idUser){

            $resultado = DB::table('ng_noticias AS n')
                        ->select('n.id_noticia','n.titulo','n.noticia','n.img','us.name','n.fecha')
                        ->join('ng_users AS us','us.id_user','=','n.id_user')
                        ->where('us.id_user','=',$idUser)
                        ->orderBy('n.fecha','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function actualizarNoticia(Request $request){

            $idNoticia = $request->input('idNoticia');
            $titulo = $request->input('tituloNoticia');
            $noticia = $request->input('noticia');

            $resultado = DB::table('ng_noticias')
                        ->where('id_noticia','=',$idNoticia)
                        ->update([
                            'titulo' => $titulo,
                            'noticia' => $noticia
                        ]);

            return response()->json($resultado);
        }

        function eliminarNoticia($idNoticia,$nameImagen){

            File::delete('noticias/'.$nameImagen);
            // Storage::delete($nameImagen);

            $resultado = DB::table('ng_noticias')
                        ->where('id_noticia','=',$idNoticia)
                        ->delete();
            return $resultado;
        }

        /**FUNCIONES PARA GUARDAR ARCHIVOS DE PRODUCTOS**/
        function cargarSelectProductos(){

            $resultado = DB::table('ng_nombresProductos AS np')
                        ->select('np.ean13')
                        ->where('np.ean13','!=',"")
                        ->orderBy('np.producto','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function buscarEan13PorNombreProducto(Request $request){

            $producto = $request->input('producto');

            $resultado = DB::table('ng_nombresProductos AS np')
                        ->select('np.ean13')
                        ->where('np.ean13','=',"$producto")
                        ->get();

            return response()->json($resultado);
        }

        function cargarSelectTipoDeDocumento(){

            $resultado = DB::table('ng_tipoDocumento AS t')
                        ->select('t.idTipo','t.observacion')
                        ->get();

            return response()->json($resultado);
        }

        function registrarDocumento(Request $request){

            $file = $request->file('archivo');
            $name = $file->getClientOriginalName();

            $ean13 = $request->ean13;
            $idPais = $request->idPais;
            $idTipo = $request->idTipo;
            $tags = $request->observacion;
            $fecha = Carbon::now();

            if(!File::exists('productos/'.$ean13)){
                File::makeDirectory('productos/'.$ean13, $mode = 0777, true, true);
            }

            if ($request->hasFile('archivo')){

                if(File::exists('productos/'.$ean13."/".$name)){
                    return response()->json(false);
                }else{

                    $file->move('productos/'.$ean13,$name);

                    $resultado = DB::table('ng_gestorDocumentos')->insert([
                        'ean13' => $ean13,
                        'idPais' => $idPais,
                        'idTipo' => $idTipo,
                        'nombreArchivo' => $name,
                        'tags' => $tags,
                        'date_add' => $fecha
                    ]);

                    return response()->json($resultado);

                }

            }

        }

        function cargarListadoDocumentosPorEan13($ean13){

            $resultado = DB::table('ng_gestorDocumentos AS ge')
                        ->select('ge.id','ge.ean13','nam.producto',DB::raw("IF(ge.idPais = 1,'ESPAÑA',NULL) AS idPais"),'tipoDoc.tipo','ge.nombreArchivo','ge.tags','ge.date_add')
                        ->join('ng_tipoDocumento AS tipoDoc','tipoDoc.idTipo','=','ge.idTipo')
                        ->join('ng_nombresProductos AS nam','nam.ean13','=','ge.ean13')
                        ->where('ge.ean13','=',$ean13)
                        ->orderBy('ge.id','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function cargarListadoCompleto(){

            $resultado = DB::table('ng_gestorDocumentos AS ge')
                        ->select('ge.id','ge.ean13','nam.producto',DB::raw("IF(ge.idPais = 1,'ESPAÑA',NULL) AS idPais")
                                ,DB::raw("CONCAT('/productos/',ge.ean13,'/',ge.nombreArchivo) AS imagen") ,'tipoDoc.tipo','ge.nombreArchivo','ge.tags','ge.date_add')
                        ->join('ng_tipoDocumento AS tipoDoc','tipoDoc.idTipo','=','ge.idTipo')
                        ->join('ng_nombresProductos AS nam','nam.ean13','=','ge.ean13')
                        ->orderBy('ge.id','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function eliminarArchivos(Request $request){

            $idArchivo = $request->idArchivo;
            $ean13 = $request->ean13;
            $nameImagen = $request->nameImagen;

            File::delete('productos/'.$ean13.'/'.$nameImagen);

            $resultado = DB::table('ng_gestorDocumentos')
                        ->where('id','=',$idArchivo)
                        ->delete();
            return $resultado;
        }
    }


?>
