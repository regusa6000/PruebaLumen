<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Carbon;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;

    class AbonosController extends Controller{

        function buscarAbonosPorFechas(Request $request){

            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $resultado = DB::table('ng_abonos AS abo')
                        ->select('abo.idFactura','abo.pedidoAx','abo.referenciaPs','osl.name AS estadoPedido'
                                ,DB::raw("IFNULL((SELECT abono.precioFinal FROM ng_abonos AS abono WHERE abono.nombreProducto = 'GASTOS TRANSPORTE' AND abono.referenciaPs = abo.referenciaPs),0) AS transporte")
                                ,DB::raw('SUM(abo.precioFinal) AS precioFinal')
                                ,DB::raw("CONCAT(DAY(abo.fechaFactura),'-',MONTH(abo.fechaFactura),'-',YEAR(abo.fechaFactura)) AS fechaFactura")
                                ,DB::raw('COUNT(abo.referenciaPs) AS cantidadProductos'))
                        ->join('hg_orders AS o','o.reference','=','abo.referenciaPs')
                        ->join('hg_order_state_lang AS osl','osl.id_order_state','=',DB::raw('o.current_state AND osl.id_lang = 1'))
                        ->where('abo.fechaFactura','>=',DB::raw("'".$fechaInicio."'"."AND abo.fechaFactura <= DATE_ADD("."'".$fechaFin."'".", INTERVAL 1 DAY)"))
                        ->groupBy('abo.idFactura')
                        ->get();

            return response()->json($resultado);
        }

        function buscarLineasAbonos(Request $request){

            $orPedido = $request->input('orPedido');

            $resultado = DB::table('ng_abonos AS abo')
                        ->select('abo.idFactura','abo.pedidoAx','abo.referenciaPs','amo.id_product',DB::raw('IFNULL(amo.name,abo.nombreProducto) as nombreProducto'),'abo.cantidadVendida'
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen")
                                ,'abo.precioFinal',DB::raw("CONCAT(DAY(abo.fechaFactura),'-',MONTH(abo.fechaFactura),'-',YEAR(abo.fechaFactura)) AS fechaFactura"))
                        ->leftJoin('aux_makro_offers AS amo','amo.itemid','=','abo.idProductAx')
                        ->leftJoin('hg_image_shop AS image_shop','image_shop.id_product','=',DB::raw('amo.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where('abo.referenciaPs','=',$orPedido)
                        ->get();

            return response()->json($resultado);
        }

        function buscarIncidenciaPorAbono(Request $request){

            $orPedido = $request->input('orPedido');

            $resultado = DB::table('ng_incidencias AS inci')
                        ->select('inci.orPedido','inci.pvcPedido','inci.tipoIncidencia','tipo.valorTipo','inci.usuarioCreacion', 'inci.descripcion'
                                ,DB::raw("CONCAT(DAY(inci.fechaCreacion),'-',MONTH(inci.fechaCreacion),'-',YEAR(inci.fechaCreacion)) AS fechaCreacion"))
                        ->join('ng_tipoIncidenciaDescripcion AS tipo','tipo.tipoIncidencia','=','inci.tipoIncidencia')
                        ->where('inci.orPedido','=',$orPedido)
                        ->get();

            return response()->json($resultado);
        }

        function countBuscarIncidenciaPorAbono(Request $request){

            $orPedido = $request->input('orPedido');

            $resultado = DB::table('ng_incidencias AS inci')
                        ->select('inci.orPedido','inci.pvcPedido','inci.tipoIncidencia','tipo.valorTipo','inci.usuarioCreacion', 'inci.descripcion'
                                ,DB::raw("CONCAT(DAY(inci.fechaCreacion),'-',MONTH(inci.fechaCreacion),'-',YEAR(inci.fechaCreacion)) AS fechaCreacion"))
                        ->join('ng_tipoIncidenciaDescripcion AS tipo','tipo.tipoIncidencia','=','inci.tipoIncidencia')
                        ->where('inci.orPedido','=',$orPedido)
                        ->get();

            return response()->json(count($resultado));
        }

    }

?>
