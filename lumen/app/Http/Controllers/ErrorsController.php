<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;

    class ErrorsController extends Controller{

        public function insertError($id_product,$id_image,$id_ax,$error,$ok){
            $resultado = DB::table('ng_errors')
                        ->insert([
                            'id_product'=> $id_product,
                            'id_image'=> $id_image,
                            'id_ax'=>$id_ax,
                            'error'=> $error,
                            'ok'=> $ok
                        ]);
            return $resultado;
        }

        public function verify($id_image){

            $resultado = DB::table('ng_errors')
                        ->select('id_image')
                        ->where('id_image','=',$id_image)
                        ->pluck('id_image')
                        ->first();

            return $resultado;
        }

        public function resultError(){

            $resultado = DB::table('ng_errors')
                        ->select('id_image')
                        ->where('error','=',1)
                        ->get();

            return response()->json($resultado);
        }

        public function updateActiveError($id_image){

            $resultado = DB::table('ng_errors')
                        ->where('id_image','=',$id_image)
                        ->update(['error' => 0]);

            return $resultado;
        }

        public function deleteError($id_image){

            $resultado = DB::table('ng_errors')
                        ->where('id_image','=',$id_image)
                        ->delete();

            return $resultado;
        }

    }
