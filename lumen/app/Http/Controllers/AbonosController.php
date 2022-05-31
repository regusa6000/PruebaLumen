<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
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
                                ,DB::raw('(SELECT COUNT(abo2.referenciaPs) FROM ng_abonos AS abo2 WHERE abo2.referenciaPs = abo.referenciaPs) AS cantidadProductos')
                                ,DB::raw('(SELECT count(mo.referenciaPs) FROM ng_motivosLineasAbonadas AS mo WHERE mo.referenciaPs = abo.referenciaPs) AS cantidadMotivados'))
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
                        ->select('abo.id','abo.idFactura','abo.pedidoAx','abo.referenciaPs'
                                ,DB::raw("IFNULL(amo.id_product,'0000') AS id_product")
                                ,DB::raw('IFNULL(amo.name,abo.nombreProducto) as nombreProducto'),'abo.cantidadVendida'
                                ,DB::raw("IFNULL(CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg'),'/orion/assets/images/gastosTransporte.png') AS imagen")
                                ,'abo.precioFinal',DB::raw("CONCAT(DAY(abo.fechaFactura),'-',MONTH(abo.fechaFactura),'-',YEAR(abo.fechaFactura)) AS fechaFactura")
                                ,DB::raw("IF((SELECT COUNT(mo.id) FROM ng_motivosLineasAbonadas AS mo WHERE mo.idLineaAbono = abo.id) = 0,'No Motivado','Motivado') AS motivo"))
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

        //Incidencias motivos y submotivos
        function cargarSelectMotivos(){

            $resultado = DB::table('ng_motivosIncidencias AS motivo')
                        ->select('motivo.id','motivo.motivo')
                        ->get();

            return response()->json($resultado);
        }
        function cargarSelectSubMotivos($idMotivo){

            $resultado = DB::table('ng_submotivoIncidencias AS sub')
                        ->select('sub.id','sub.idMotivo','sub.submotivo')
                        ->where('sub.idMotivo','=',$idMotivo)
                        ->get();

            return response()->json($resultado);
        }
        function registrarMotivosYSubMotivos(Request $request){

            $referenciaPs = $request->input('referenciaPs');
            $idAbonoLinea = $request->input('idAbonoLinea');
            $pedidoAx = $request->input('pedidoAx');
            $idFactura = $request->input('idFactura');
            $idMotivo = $request->input('idMotivo');
            $idSubMotivo = $request->input('idSubMotivo');
            $idProducto = $request->input('idProducto');
            $nombreProducto = $request->input('nombreProducto');
            $cantidadVendida = $request->input('cantidadVendida');
            $precioFinal = $request->input('precioFinal');
            $fechaRegistro = Carbon::now();

            $resultado = DB::table('ng_motivosLineasAbonadas')->insert([
                'idLineaAbono' => $idAbonoLinea,
                'referenciaPs' => $referenciaPs,
                'pedidoAx' => $pedidoAx,
                'idFactura' => $idFactura,
                'idMotivo' => $idMotivo,
                'idSubMotivo' => $idSubMotivo,
                'idProducto' => $idProducto,
                'nombreProducto' => $nombreProducto,
                'cantidadVendida' => $cantidadVendida,
                'precioFinal' => $precioFinal,
                'fechaRegistro' => $fechaRegistro
            ]);

        return response()->json($resultado);
        }
    }

?>
