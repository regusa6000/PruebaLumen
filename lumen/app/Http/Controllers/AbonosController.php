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

            $resultado = DB::table('ng_lineas_abonos AS abo')
                        ->select('abo.idFactura','abo.pedidoAx','abo.referenciaPs','osl.name AS estadoPedido'
                                ,DB::raw("IFNULL((SELECT SUM(abono.precioFinal) FROM ng_lineas_abonos AS abono WHERE abono.nombreProducto = 'GASTOS TRANSPORTE' AND abono.referenciaPs = abo.referenciaPs),0) AS transporte")
                                ,DB::raw('SUM(abo.precioFinal) AS precioFinal')
                                ,DB::raw("CONCAT(DAY(abo.fechaAbono),'-',MONTH(abo.fechaAbono),'-',YEAR(abo.fechaAbono)) AS fechaFactura")
                                ,DB::raw('(SELECT COUNT(abo2.referenciaPs) FROM ng_lineas_abonos AS abo2 WHERE abo2.referenciaPs = abo.referenciaPs) AS cantidadProductos')
                                ,DB::raw('(SELECT count(mo.referenciaPs) FROM ng_motivosLineasAbonadas AS mo WHERE mo.referenciaPs = abo.referenciaPs) AS cantidadMotivados'))
                        ->join('hg_orders AS o','o.reference','=','abo.referenciaPs')
                        ->join('hg_order_state_lang AS osl','osl.id_order_state','=',DB::raw('o.current_state AND osl.id_lang = 1'))
                        ->where('abo.fechaAbono','>=',DB::raw("'".$fechaInicio."'"."AND abo.fechaAbono <= DATE_ADD("."'".$fechaFin."'".", INTERVAL 1 DAY)"))
                        ->groupBy('abo.idFactura')
                        ->get();

            return response()->json($resultado);
        }

        function buscarLineasAbonos(Request $request){

            $orPedido = $request->input('orPedido');

            $resultado = DB::table('ng_lineas_abonos AS abo')
                        ->select('abo.id','abo.idFactura','abo.pedidoAx','abo.referenciaPs','us.name AS nameUsuario','moi.motivo as motivoName','subm.submotivo'
                                ,DB::raw("IFNULL(amo.id_product,'0000') AS id_product")
                                ,DB::raw('IFNULL(amo.name,abo.nombreProducto) as nombreProducto'),'abo.cantidadVendida'
                                ,DB::raw("IFNULL(CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg'),'/orion/assets/images/gastosTransporte.png') AS imagen")
                                ,'abo.precioFinal',DB::raw("CONCAT(DAY(abo.fechaAbono),'-',MONTH(abo.fechaAbono),'-',YEAR(abo.fechaAbono)) AS fechaAbono")
                                ,DB::raw("IF((SELECT COUNT(mo.id) FROM ng_motivosLineasAbonadas AS mo WHERE mo.idLineaAbono = abo.id) = 0,'No Motivado','Motivado') AS motivo"))
                        ->leftJoin('aux_makro_offers AS amo','amo.itemid','=','abo.idProductAx')
                        ->leftJoin('hg_image_shop AS image_shop','image_shop.id_product','=',DB::raw('amo.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->leftJoin('ng_motivosLineasAbonadas AS mo2','mo2.idLineaAbono','=','abo.id')
                        ->leftJoin('ng_users AS us','us.id_user','=','mo2.idUsuario')
                        ->leftJoin('ng_motivosIncidencias AS moi','moi.id','=','mo2.idMotivo')
                        ->leftJoin('ng_submotivoIncidencias AS subm','subm.id','=','mo2.idSubMotivo')
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
            $idUsuario = $request->input('idUsuario');
            $pedidoAx = $request->input('pedidoAx');
            $idFactura = $request->input('idFactura');
            $idMotivo = $request->input('idMotivo');
            $idSubMotivo = $request->input('idSubMotivo');
            $idProducto = $request->input('idProducto');
            $nombreProducto = $request->input('nombreProducto');
            $cantidadVendida = $request->input('cantidadVendida');
            $precioFinal = $request->input('precioFinal');
            $fechaRegistro = Carbon::now();

            $resultadoBusqueda = DB::table('ng_motivosLineasAbonadas AS mo')
                                ->select('*')
                                ->where('mo.idLineaAbono','=',$idAbonoLinea)
                                ->get();

            if(count($resultadoBusqueda) > 0){

                $resultadoActualizar = DB::table('ng_motivosLineasAbonadas')
                                        ->where('idLineaAbono','=',$idAbonoLinea)
                                        ->update([
                                            'idUsuario' => $idUsuario,
                                            'idMotivo' => $idMotivo,
                                            'idSubMotivo' => $idSubMotivo,
                                        ]);

                return response()->json($resultadoActualizar);
            }else{

                $resultado = DB::table('ng_motivosLineasAbonadas')->insert([
                    'idLineaAbono' => $idAbonoLinea,
                    'idUsuario' => $idUsuario,
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

        //Incidencia Abonos Motivos
        function incidenciaAbonosMotivos(Request $request){

            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $resultado = DB::table('ng_motivosLineasAbonadas AS mo')
                        ->select('moi.motivo','sub.submotivo',DB::raw('SUM(mo.precioFinal) AS precioFinal'),DB::raw('SUM(mo.cantidadVendida) AS cantidadVendida'))
                        ->join('ng_lineas_abonos AS a','a.id','=','mo.idLineaAbono')
                        ->join('ng_motivosIncidencias AS moi','moi.id','=','mo.idMotivo')
                        ->join('ng_submotivoIncidencias AS sub','sub.id','=','mo.idSubMotivo')
                        ->whereBetween('a.fechaAbono',[$fechaInicio,$fechaFin])
                        ->groupBy('moi.id','sub.id')
                        ->get();

            return response()->json($resultado);
        }

        //Abonos por Motivo Transporte
        function abonosMotivosTransporte(Request $request){

            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $resultado = DB::table('ng_motivosLineasAbonadas AS moabono')
                        ->select('motivo.motivo','submotivo.submotivo'
                                ,DB::raw('SUM(lin_abo.precioFinal) AS totalSinIva')
                                ,DB::raw('COUNT(o.reference) AS n_abonos')
                                ,DB::raw("IF(carrier.name = 'Envío Urgente', 'GLS', carrier.name) AS agencia"))
                        ->join('ng_lineas_abonos AS lin_abo','lin_abo.id','=','moabono.idLineaAbono')
                        ->join('ng_motivosIncidencias AS motivo','motivo.id','=','moabono.idMotivo')
                        ->join('ng_submotivoIncidencias AS submotivo','submotivo.id','=','moabono.idSubMotivo')
                        ->join('hg_orders AS o','o.reference','=','lin_abo.referenciaPs')
                        ->join('hg_carrier AS carrier','carrier.id_carrier','=','o.id_carrier')
                        ->where('motivo.id','=',DB::raw("2 AND lin_abo.fechaAbono BETWEEN '".$fechaInicio."' AND '".$fechaFin."'"))
                        ->groupBy('motivo.id','submotivo.id','o.id_carrier')
                        ->get();

            return response()->json($resultado);
        }


        //Indice De Abonos por Canal
        function indiceAbonosPorCanal(Request $request){

            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $resultado = DB::table('ng_lineas_abonos AS abos')
                        ->select('canales.canal',DB::raw('ROUND(SUM(abos.precioFinal),2) AS abonos')
                                ,DB::raw("ROUND((SELECT sum(lineas.lineAmount) FROM ng_lineasFacturasAx AS lineas
                                            INNER JOIN hg_orders ON hg_orders.reference = lineas.purcharseOrder
                                            INNER JOIN ng_canales_payment ON ng_canales_payment.payment = hg_orders.payment
                                            WHERE DATE(lineas.fechaFactura) >= DATE('$fechaInicio')
                                                    AND DATE(lineas.fechaFactura) <= DATE('$fechaFin')
                                                    AND ng_canales_payment.canal = canales.canal),2) AS facturas")
                                ,DB::raw("ROUND(IFNULL((sum(abos.precioFinal) * -100) /
                                            (SELECT sum(lineas.lineAmount) FROM ng_lineasFacturasAx AS lineas
                                            INNER JOIN hg_orders ON hg_orders.reference = lineas.purcharseOrder
                                            INNER JOIN ng_canales_payment ON ng_canales_payment.payment = hg_orders.payment
                                            WHERE DATE(lineas.fechaFactura) >= DATE('$fechaInicio')
                                                    AND DATE(lineas.fechaFactura) <= DATE('$fechaFin')
                                                    AND ng_canales_payment.canal = canales.canal),0) , 2) AS porcentajeAbonos"))

                        ->join('hg_orders AS o','o.reference','=','abos.referenciaPs')
                        ->join('ng_canales_payment AS canales','canales.payment','=','o.payment')
                        ->where(DB::raw('DATE(abos.fechaAbono)'),'>=',DB::raw("DATE('$fechaInicio') AND DATE(abos.fechaAbono) <= DATE('$fechaFin')"))
                        ->groupBy('canales.canal')
                        ->get();

            return response()->json($resultado);
        }


        //Abonos por productos entre fechas
        function abonosProductosEntreFechas(Request $request){

            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $resultado = DB::table('ng_lineasFacturasAx AS lineas')
                        ->select('lineas.itemid','lineas.name'
                                ,DB::raw("ROUND((SELECT SUM(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                            WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                            AND ng_lineasFacturasAx.itemid = lineas.itemid AND (ng_lineasFacturasAx.purcharseOrder NOT LIKE '%inci-%' or ng_lineasFacturasAx.purcharseOrder NOT LIKE '%repo-%')
                                            GROUP BY ng_lineasFacturasAx.itemid),2) AS facturas")
                                ,DB::raw("ROUND((SELECT SUM(ng_lineas_abonos.precioFinal) FROM ng_lineas_abonos
                                            WHERE DATE(ng_lineas_abonos.fechaAbono) >= DATE('$fechaInicio') AND DATE(ng_lineas_abonos.fechaAbono) <= DATE('$fechaFin')
                                            AND ng_lineas_abonos.idProductAx <> '99989' AND ng_lineas_abonos.idProductAx = lineas.itemid),2) AS abonos")
                                ,DB::raw("ROUND(((SELECT SUM(ng_lineas_abonos.precioFinal) FROM ng_lineas_abonos
                                            WHERE DATE(ng_lineas_abonos.fechaAbono) >= DATE('$fechaInicio') AND DATE(ng_lineas_abonos.fechaAbono) <= DATE('$fechaFin')
                                            AND ng_lineas_abonos.idProductAx <> '99989' AND ng_lineas_abonos.idProductAx = lineas.itemid) * -100)/
                                            (SELECT SUM(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                            WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                            AND ng_lineasFacturasAx.itemid = lineas.itemid AND (ng_lineasFacturasAx.purcharseOrder NOT LIKE '%inci-%' or ng_lineasFacturasAx.purcharseOrder NOT LIKE '%repo-%')
                                            GROUP BY ng_lineasFacturasAx.itemid),2) AS porcentajeAbonos")
                                ,DB::raw("ROUND((SELECT SUM(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                            WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                            AND ng_lineasFacturasAx.itemid = lineas.itemid AND ng_lineasFacturasAx.purcharseOrder LIKE 'inci-%' AND ng_lineasFacturasAx.lineAmount > 0),2) AS incidencias")
                                ,DB::raw("ROUND(((SELECT SUM(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                            WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                            AND ng_lineasFacturasAx.itemid = lineas.itemid AND ng_lineasFacturasAx.purcharseOrder LIKE 'inci-%' AND ng_lineasFacturasAx.lineAmount > 0 )* 100 /
                                            (SELECT SUM(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                            WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                            AND ng_lineasFacturasAx.itemid = lineas.itemid AND (ng_lineasFacturasAx.purcharseOrder NOT LIKE '%inci-%' or ng_lineasFacturasAx.purcharseOrder NOT LIKE '%repo-%')
                                            GROUP BY ng_lineasFacturasAx.itemid )),2) AS porcentajeIncis"))
                        ->where(DB::raw('DATE(lineas.fechaFactura)'),'>=',DB::raw("DATE('$fechaInicio') AND DATE(lineas.fechaFactura) <= DATE('$fechaFin')
                                        AND ((SELECT count(ng_lineasFacturasAx.lineAmount) FROM ng_lineasFacturasAx
                                                    WHERE DATE(ng_lineasFacturasAx.fechaFactura) >= DATE('$fechaInicio') AND DATE(ng_lineasFacturasAx.fechaFactura) <= DATE('$fechaFin')
                                                    AND ng_lineasFacturasAx.itemid = lineas.itemid AND ng_lineasFacturasAx.purcharseOrder LIKE 'inci-%' AND ng_lineasFacturasAx.lineAmount > 0 )) > 0

                                        AND ((SELECT count(ng_lineas_abonos.precioFinal) FROM ng_lineas_abonos
                                                    WHERE DATE(ng_lineas_abonos.fechaAbono) >= DATE('$fechaInicio') AND DATE(ng_lineas_abonos.fechaAbono) <= DATE('$fechaFin')
                                                    AND ng_lineas_abonos.idProductAx <> '99989' AND ng_lineas_abonos.idProductAx = lineas.itemid))> 0

                                        AND lineas.itemid <> '99989' AND lineas.lineAmount > 0"))
                        ->groupBy('lineas.itemid')
                        ->get();

            return response()->json($resultado);
        }

        //Top 10 Abonos/Motivos
        function top10AbonoMotivo(){

            $resultado = DB::table('ng_lineas_abonos AS abo')
                        ->select('abo.id','abo.fechaAbono','nombre_moti.motivo','nombre_submoti.submotivo',DB::raw('SUM(abo.precioFinal) AS total') )
                        ->join('ng_motivosLineasAbonadas AS moti','moti.referenciaPs','=','abo.referenciaPs')
                        ->join('ng_motivosIncidencias AS nombre_moti','nombre_moti.id','=','moti.idMotivo')
                        ->join('ng_submotivoIncidencias AS nombre_submoti','nombre_submoti.id','=','moti.idSubMotivo')
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, abo.fechaAbono,NOW())'),'<=',DB::raw('30 AND moti.referenciaPs IS NOT NULL'))
                        ->groupBy('moti.idMotivo','moti.idSubMotivo')
                        ->orderBy(DB::raw('SUM(abo.precioFinal)'),'ASC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        //Top 10 Productos Abonados en el ultimo mes
        function top10ProductosAbonados(){

            $resultado = DB::table('ng_lineas_abonos AS abo')
                        ->select('aux.name','aux.itemid',DB::raw('SUM(abo.precioFinal)AS totalSinIva'))
                        ->join('aux_makro_offers AS aux','aux.itemid','=','abo.idProductAx')
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, abo.fechaAbono,NOW())'),'<=',30)
                        ->groupBy('abo.idProductAx')
                        ->orderBy(DB::raw('SUM(abo.precioFinal)'),'ASC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

    }

?>
