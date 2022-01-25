<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RangosController extends Controller{

    function productosPublicadosMakro(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                DB::raw("ROUND(am.pack) AS pack"),
                                DB::raw("ROUND(am.pallet) AS pallet"),
                                DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                DB::raw("CONCAT(ROUND(am.price,2),'€') AS price"),
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
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
                    ->select(   'am.gtin',
                                'am.sku',
                                'am.name',
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw("ROUND(am.price,2) AS price"),
                                'am.stock',
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos'),
                                'amr.ean13',
                                'amr.nombreProducto',
                                'amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'),
                                DB::raw('ROUND(am.margen,2) AS margen'),
                                DB::raw('ROUND(am.pack) AS pack'),
                                DB::raw('ROUND(am.pallet) AS pallet'),
                                DB::raw('ROUND(am.pmp) AS pmp'))
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
                    ->select(   'amr.ean13','amr.id_product','amr.nombreProducto','amr.nombreAtributo','amr.valorAtributo','amr.rango',
                                DB::raw("CONCAT(ROUND(precio_sin_iva,2),'€') as precio_sin_iva"),
                                DB::raw("CONCAT(ROUND(((amr.precio_sin_iva - amr.pmp)/ amr.precio_sin_iva)*100,2),'%') AS margenNuevo"))
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
                    ->update(['amr.precio_sin_iva' => $precio]);

        return $resultado;
    }

    function eliminarRango($ean13,$rango){

        $resultado = DB::table('aux_makro_rangos')
                    ->where('ean13','=',$ean13)
                    ->where('rango','=',$rango)
                    ->delete();

        return $resultado;
    }

    function buscarListado($ean13){

        $resultado = DB::table('aux_makro_offers AS amo')
                    ->select(   'amo.id_product','amo.sku','amo.name',
                                DB::raw("IFNULL(amo.name_att,'Sin valor') AS name_att"),
                                DB::raw("IFNULL(amo.name_value_att,'Sin valor') AS name_value_att"))
                    ->where('amo.sku','=',$ean13)
                    ->get();

        return response()->json($resultado);
    }

    function registrarNuevoRango(Request $request){


        $id_product = $request->input('id_product');
        $ean13 = $request->input('ean13');
        $name = $request->input('nombreProducto');
        $atributo = $request->input('nombreAtributo');
        $valorAtributo = $request->input('valorAtributo');
        $rango = $request->input('rango');
        $margen = $request->input('margen');
        $pmp = $request->input('pmp');
        $precio = $request->input('precio_sin_iva');

        $consulta = DB::table('aux_makro_rangos')->insert([
            'id_product'=>$id_product,
            'ean13'=>$ean13,
            'nombreProducto'=>$name,
            'nombreAtributo'=>$atributo,
            'valorAtributo'=>$valorAtributo,
            'rango'=>$rango,
            'margen'=>$margen,
            'pmp'=>$pmp,
            'precio_sin_iva'=>$precio
        ]);

        return $consulta;

    }

}
