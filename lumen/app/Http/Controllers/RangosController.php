<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RangosController extends Controller{

    function productosPublicadosMakro(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS pricePs"),
                                DB::raw("ROUND(am.pack) AS pack"),
                                DB::raw("ROUND(am.pallet) AS pallet"),
                                DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                DB::raw("CONCAT(ROUND(IFNULL(amp.precio_fijo,am.price),2),'€') AS priceMakro"),
                                DB::raw('ROUND(amp.precio_fijo,2) AS precio_fijo'),
                                DB::raw('ROUND(am.precio_calculado,2) AS precioCalculado'),
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->leftJoin('aux_makro_precios_fijos AS amp','amp.sku','=','am.sku')
                    ->where('am.status','=',1)
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();

        return response()->json($resultado);
    }

    /**CONSULTAS PARA LLENAR LOS SELECTS**/
    function productosPublicadosMakroConRangoYConStock(){

        $resultado = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                    DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS pricePs"),
                                    DB::raw("ROUND(am.pack) AS pack"),
                                    DB::raw("ROUND(am.pallet) AS pallet"),
                                    DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                    DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                    DB::raw("CONCAT(ROUND(am.price,2),'€') AS priceMakro"),
                                    DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
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
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                    DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS pricePs"),
                                    DB::raw("ROUND(am.pack) AS pack"),
                                    DB::raw("ROUND(am.pallet) AS pallet"),
                                    DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                    DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                    DB::raw("CONCAT(ROUND(am.price,2),'€') AS priceMakro"),
                                    DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
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
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                    DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS pricePs"),
                                    DB::raw("ROUND(am.pack) AS pack"),
                                    DB::raw("ROUND(am.pallet) AS pallet"),
                                    DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                    DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                    DB::raw("CONCAT(ROUND(am.price,2),'€') AS priceMakro"),
                                    DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
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
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                    DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS pricePs"),
                                    DB::raw("ROUND(am.pack) AS pack"),
                                    DB::raw("ROUND(am.pallet) AS pallet"),
                                    DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                    DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                    DB::raw("CONCAT(ROUND(am.price,2),'€') AS priceMakro"),
                                    DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
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
                                DB::raw("ROUND(amr.porcentaje_dto,2) AS porcentaje_dto"),
                                DB::raw("ROUND(precio_sin_iva,2) as precio_sin_iva"),
                                DB::raw("ROUND(((amr.precio_sin_iva - amr.pmp)/ amr.precio_sin_iva)*100,2) AS margenNuevo"))
                    ->where('amr.ean13','=',$ean13)
                    ->get();
        return response()->json($resultado);
    }

    function actualizarRango(Request $request){

        $ean13 = $request->input('ean13');
        $rango = $request->input('rango');
        $descuento = $request->input('descuento');
        $precio = $request->input('precio');

        $resultado = DB::table('aux_makro_rangos AS amr')
                    ->where('amr.ean13','=',DB::raw("$ean13 AND amr.rango = $rango"))
                    ->update(['amr.precio_sin_iva' => $precio, 'amr.porcentaje_dto' => $descuento]);

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
        $descuento = $request->input('porcentaje_dto');
        $precioPadre = $request->input('precioUnidadAx');
        $precioPs = $request->input('precioPadre');

        $consulta = DB::table('aux_makro_rangos')->insert([
            'id_product'=>$id_product,
            'ean13'=>$ean13,
            'nombreProducto'=>$name,
            'nombreAtributo'=>$atributo,
            'valorAtributo'=>$valorAtributo,
            'rango'=>$rango,
            'margen'=>$margen,
            'pmp'=>$pmp,
            'precio_sin_iva'=>$precio,
            'porcentaje_dto'=>$descuento,
            'precioUnidadAx'=>$precioPadre,
            'precioPs'=>$precioPs
        ]);

        return $consulta;

    }


    function pruebaRangos(){

        $productosPublicados = DB::table('aux_makro_offers AS am')
                    ->select(   'am.gtin','am.sku','am.itemid','am.name','am.stock',
                                DB::raw("CONCAT(ROUND(am.pricePs,2),'€') AS 'pricePs'"),
                                DB::raw("ROUND(am.pack) AS pack"),
                                DB::raw("ROUND(am.pallet) AS pallet"),
                                DB::raw("CONCAT(ROUND(am.pmp,2),'€') AS pmp"),
                                DB::raw("CONCAT(ROUND(am.margen,2),'%') AS margen"),
                                DB::raw("CONCAT(ROUND(am.price,2),'€') AS priceMakro"),
                                DB::raw("IFNULL(am.category_default,'Sin categoría por defecto') AS category_default"),
                                DB::raw('(SELECT COUNT(aux_makro_rangos.rango)FROM aux_makro_rangos WHERE aux_makro_rangos.ean13 = am.sku) AS contadorRangos')
                                ,'amr.ean13','amr.nombreProducto','amr.rango',
                                DB::raw('ROUND(amr.precio_sin_iva,2) as precio_sin_iva'))
                    ->leftJoin('aux_makro_rangos AS amr','amr.ean13','=','am.sku')
                    ->where('am.status','=',1)
                    ->groupBy('am.sku')
                    ->orderBy('am.name','ASC')
                    ->get();


        $jsonResult = array();

        for($a = 0 ; $a < count($productosPublicados); $a++){
            $jsonResult[$a]['producto'] = $productosPublicados[$a];
            $jsonResult[$a]['rangos'] = DB::table('aux_makro_rangos AS amr')
                                                ->select('*')
                                                ->where('amr.ean13','=',$productosPublicados[$a]->ean13)
                                                ->get();

        }

        return response()->json($jsonResult);
    }


    /**Precios Fijos**/
    function cargarSelectProductos(){

        $resultado = DB::table('aux_makro_offers AS ma')
                    ->select('ma.sku','ma.name')
                    ->where('ma.status','=',1)
                    ->get();

        return response()->json($resultado);
    }

    function cargarTablaPreciosFijos(){

        $resultado = DB::table('aux_makro_precios_fijos AS amp')
                    ->select('amp.id','amp.sku',DB::raw('ROUND(amp.precio_fijo,2) AS precio_fijo'),'amp.fecha','am.name')
                    ->join('aux_makro_offers AS am','am.sku','=',DB::raw('amp.sku AND am.status = 1'))
                    ->get();

        return response()->json($resultado);
    }

    function registrarPrecioFijo(Request $request){

        $sku = $request->input('sku');
        $precioFijo = $request->input('precioFijo');
        $fecha = Carbon::now();

        $resultado = DB::table('aux_makro_precios_fijos')
                    ->insert([
                        'sku' => $sku,
                        'precio_fijo' => $precioFijo,
                        'fecha' => $fecha
                    ]);

        return response()->json($resultado);
    }

    function actualizarPrecioFijo(Request $request){
        $id = $request->input('id');
        $precioNuevo = $request->input('precioNuevo');

        $resultado = DB::table('aux_makro_precios_fijos as amp')
                    ->where('amp.id','=',$id)
                    ->update(['precio_fijo' => $precioNuevo]);

        return $resultado;
    }

    function eliminarPrecioFijo($id){

        $resultado = DB::table('aux_makro_precios_fijos')
                    ->where('id','=',$id)
                    ->delete();

        return $resultado;
    }

}
