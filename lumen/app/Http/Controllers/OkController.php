<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;

    class OkController extends  Controller{

        public function insertOk($id_product,$id_image,$error,$ok){

            $resultado = DB::table('ng_errors')
                        ->insert([
                            'id_product'=>$id_product,
                            'id_image'=>$id_image,
                            'error'=>$error,
                            'ok'=>$ok
                        ]);

            return $resultado;
        }

        public function verifyOk($id_image){

            $resultado = DB::table('ng_errors')
                        ->select('id_image')
                        ->where('id_image','=',$id_image)
                        ->pluck('id_image')
                        ->first();

            return $resultado;
        }

        public function resultOk(){

            $resultado = DB::table('ng_errors')
                        ->select('id_image')
                        ->where('ok','=',1)
                        ->get();

            return response()->json($resultado);
        }

        public function updateActiveOk($id_image){

            $resultado = DB::table('ng_errors')
                        ->where('id_image','=',$id_image)
                        ->update(['ok'=>0]);

            return $resultado;
        }

        public function deleteOk($id_image){

            $resultado = DB::table('ng_errors')
                        ->where('id_image','=',$id_image)
                        ->delete();

            return $resultado;
        }

    }

?>
