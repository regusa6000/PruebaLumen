<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class RangosController extends Controller{

    function productosPublicadosMakro(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock')
                    ->where('am.status','=',1)
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    function listaDeRangosMakro($ean13){

        $resultado = DB::table('aux_makro_rangos AS amr')
                    ->select('*')
                    ->where('amr.ean13','=',$ean13)
                    ->get();
        return response()->json($resultado);
    }

}
