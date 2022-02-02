<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;

    class PrevisionesController extends Controller{


        /** FUNCIONES DASHBOARS **/

        function dashboardsTodos(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                        o.reference NOT LIKE 'INCI-%' AND
                                                        o.valid = 1 AND
                                                        o.current_state <> 6 AND
                                                        o.current_state <> 7)*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Todos')
                        ->get();

            return $resultado;
        }

        function dashboardsOrion91(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    (o.payment = 'Pago con tarjeta Redsys' OR
                                                    o.payment = 'Redsys BBVA' OR
                                                    o.payment = 'Paga Fraccionado' OR
                                                    o.payment = 'Sequra - Pago flexible' OR
                                                    o.payment = 'Bizum' OR
                                                    o.payment = 'Bizum - Pago online' OR
                                                    o.payment = 'PayPal' OR
                                                    o.payment = 'Transferencia bancaria')
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                        o.reference NOT LIKE 'INCI-%' AND
                                                        o.valid = 1 AND
                                                        o.current_state <> 6 AND
                                                        o.current_state <> 7 AND
                                                        (o.payment = 'Pago con tarjeta Redsys' OR
                                                        o.payment = 'Redsys BBVA' OR
                                                        o.payment = 'Paga Fraccionado' OR
                                                        o.payment = 'Sequra - Pago flexible' OR
                                                        o.payment = 'Bizum' OR
                                                        o.payment = 'Bizum - Pago online' OR
                                                        o.payment = 'PayPal' OR
                                                        o.payment = 'Transferencia bancaria')
                                                        )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','ORION91')
                        ->get();

            return $resultado;
        }

        function dashboardsAmazon(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Waadby Payment'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                        o.reference NOT LIKE 'INCI-%' AND
                                                        o.valid = 1 AND
                                                        o.current_state <> 6 AND
                                                        o.current_state <> 7 AND
                                                        o.payment = 'Waadby Payment'
                                                        )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Amazon')
                        ->get();

            return $resultado;
        }

        function dashboardsAliExpress(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'AliExpress Payment'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                            FROM hg_orders AS o
                                            WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'AliExpress Payment'
                                                    )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Aliexpress')
                        ->get();

            return $resultado;
        }

        function dashboardsMakro(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Makro'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                            FROM hg_orders AS o
                                            WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Makro'
                                                    )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Makro')
                        ->get();

            return $resultado;
        }

        function dashboardsManoMano(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Manomano'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                            FROM hg_orders AS o
                                            WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Manomano'
                                                    )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Manomano')
                        ->get();

            return $resultado;
        }

        function dashboardsGroupon(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Groupon'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                            FROM hg_orders AS o
                                            WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'Groupon'
                                                    )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','Groupon')
                        ->get();

            return $resultado;
        }

        function dashboardsMequedoUno(){

            $resultado = DB::table('ng_previsiones_ventas AS ng')
                        ->select('ng.nombre_mes','ng.nombre_canal','ng.dias_mes',
                                    DB::raw("ROUND(ng.importe,2) AS 'ImporteTotal'"),
                                    DB::raw("ROUND((ng.importe/ng.dias_mes),2) AS 'DiarioMes'"),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid_tax_excl),2)
                                                FROM hg_orders AS o
                                                WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'MEQUEDOUNO'
                                                    ) AS 'TotalActualAyer'"),
                                    DB::raw("ROUND(((SELECT sum(o.total_paid_tax_excl)
                                            FROM hg_orders AS o
                                            WHERE DATEDIFF(NOW(), o.date_add) = 1 AND
                                                    o.reference NOT LIKE 'INCI-%' AND
                                                    o.valid = 1 AND
                                                    o.current_state <> 6 AND
                                                    o.current_state <> 7 AND
                                                    o.payment = 'MEQUEDOUNO'
                                                    )*100)/(ng.importe/ng.dias_mes),2) AS 'porcentaje'"))
                        ->where('ng.mes','=',1)
                        ->where('ng.nombre_canal','=','MequedoUno')
                        ->get();

            return $resultado;
        }


        /**TOP**/
        function productosTop(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('od.product_id','pl.name',DB::raw("ROUND(SUM(od.total_price_tax_excl),2) AS suma"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=', DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where(DB::raw('DATEDIFF(NOW(),o.date_add)'),'=',DB::raw("0 AND o.valid = 1 AND o.reference NOT LIKE 'INCI-%'"))
                        ->groupBy('o.payment')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_excl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function canalesTop(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('cp.canal',DB::raw("ROUND(sum(o.total_paid_tax_excl),2) AS 'total'"))
                        ->leftJoin('ng_canales_pago AS cp','cp.pago','=','o.payment')
                        ->where(DB::raw('DATEDIFF(NOW(),o.date_add)'),'=',DB::raw("0 AND o.valid = 1 AND o.reference NOT LIKE 'INCI-%'"))
                        ->groupBy('cp.canal')
                        ->orderBy(DB::raw('sum(o.total_paid_tax_excl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopIncidenciasHoy(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select(   'od.product_id',
                                    'pl.name',
                                    DB::raw("SUM(od.product_quantity) 'cantidad'"),
                                    DB::raw("ROUND(sum(od.total_price_tax_excl),2) AS 'suma_importe'"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where(DB::raw('DATEDIFF(NOW(),o.date_add)'),'>',DB::raw("30 AND o.reference LIKE 'INCI-%'"))
                        ->groupBy('od.product_id')
                        ->orderBy(DB::raw('sum(od.total_price_tax_excl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }


        /**Prevision de Incidencias**/
        function previsionIncidencias(){

            $resultado = DB::table('hg_orders AS o')
                        ->select(   DB::raw("ROUND(SUM(o.total_paid_tax_excl),2) AS 'suma_ayer'"),
                                    DB::raw("ROUND((SELECT(p_inci.importe/p_inci.dias_mes)
                                                FROM ng_previsiones_incis AS p_inci
                                                WHERE p_inci.mes = MONTH(NOW()) AND
                                                      p_inci.amo = YEAR(NOW())),2) AS 'previsionDiaria'"),
                                    DB::raw("ROUND((SUM(o.total_paid_tax_excl)*100/(SELECT(p_inci.importe/p_inci.dias_mes) FROM ng_previsiones_incis AS p_inci
                                                                                                                           WHERE p_inci.mes = MONTH(NOW()) AND
                                                                                                                                 p_inci.amo = YEAR(NOW()))),2) AS 'tanto_Previsto'"))
                        ->where(DB::raw('DATEDIFF(NOW(),o.date_add)'),'=',DB::raw("1 AND o.valid = 1 AND o.reference LIKE 'INCI-%'"))
                        ->get();

            return response()->json($resultado);
        }
    }

?>
