<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RangosController extends Controller{

    function productosPublicadosMakro(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',1)
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    /**CONSULTAS PARA LLENAR LOS SELECTS**/
    function productosPublicadosMakroConRangoYConStock(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',DB::raw("1 AND am.stock > 0 AND amr.ean13 IS NOT NULL"))
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    function productosPublicadosMakroConRangoYSinStock(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',DB::raw("1 AND am.stock = 0 AND amr.ean13 IS NOT NULL"))
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    function productosPublicadosMakroSinRangoYConStock(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',DB::raw("1 AND am.stock > 0 AND amr.ean13 IS NULL"))
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }
    function productosPublicadosMakroSinRangoYSinStock(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"), 'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',DB::raw("1 AND am.stock = 0 AND amr.ean13 IS NULL"))
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    function listaDeRangosMakro($ean13){

        $resultado = DB::table('aux_makro_rangos AS amr')
                    ->select(   'amr.ean13','amr.id_product','amr.nombreProducto','amr.nombre_Atributo','amr.valorAtributo','amr.rango',
                                DB::raw('ROUND(precio_sin_iva,2) as precio_sin_iva'))
                    ->where('amr.ean13','=',$ean13)
                    ->get();
        return response()->json($resultado);
    }

    function actualizarRango(Request $request){

        $ean13 = $request->input('ean13');
        $rango = $request->input('rango');
        $precio = $request->input('precio');

        $resultado = DB::table('aux_makro_rangos AS amr')
                    ->where('amr.ean13','=',DB::raw("$ean13 AND amr.rango = $rango"))
                    ->update(['amr.precio_sin_iva' => (float)$precio]);

        return $resultado;
    }

    function buscarListado($ean13){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select('*')
                    ->where('am.sku','=',$ean13)
                    ->get();

        return response()->json($resultado);
    }

}
