<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;

    class EstadisticasController extends Controller{

        function importeDeVentas(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT round(SUM(o.total_paid),2) FROM hg_orders AS o
                                        WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                        (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' or o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR  o.payment = 'Bizum' or o.payment = 'PayPal'
                                        OR o.payment = 'Transferencia bancaria') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function manoMano(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                        WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                        (o.payment = 'Manomano') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function carrefour(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'Carrefour') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function aliExpress(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE   YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'AliExpress Payment') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function amazon(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'Waadby Payment') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function groupon(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'Groupon') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function embargos(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'EMBARGOS') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function mequedoUno(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT round(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            o.payment = 'MEQUEDOUNO' AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function fnac(){
            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'Fnac MarketPlace') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function wish(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.id_customer = '242380') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function makro(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'Makro') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function pcComponentes(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'PcComponentes') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sprinter(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'Sprinter') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function bulevip(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('DAY(hg_orders.date_add) AS dia'),
                                DB::raw('MONTH(hg_orders.date_add) AS mes'),
                                DB::raw('YEAR(hg_orders.date_add) AS amo'),
                                DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA"),
                                DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)  AND
                                            (o.payment = 'BuleVip') AND o.current_state <> 6 AND o.current_state <> 7) AS IMPORTE"))
                        ->join('hg_ewax_orders  AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw("YEAR (hg_orders.date_add)>2020 and hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1 AND week(hg_orders.date_add,7)"),'>',DB::raw('WEEK(NOW(),7)-2'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        //Sumatorias Semanales

        function sumatoriaPorSemana(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatoriaOrion(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT round(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND o.id_customer
                                            <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' or o.payment = 'Paga Fraccionado' OR o.payment
                                            = 'Sequra - Pago flexible' OR o.payment = 'Bizum' or o.payment = 'PayPal'
                                            OR o.payment = 'Transferencia bancaria' AND o.current_state <> 6 AND o.current_state <> 7)) AS ORION91_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatoriaManoMano(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'Manomano') AND o.current_state <> 6 AND o.current_state <> 7) AS MANOMANO_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioCarrefour(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'Carrefour') AND o.current_state <> 6 AND o.current_state <> 7) AS CARREFOUR_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioAliExpress(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND
                                            (o.payment = 'AliExpress Payment') AND o.current_state <> 6 AND o.current_state <> 7) AS ALIEXPRESS_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatoriaAmazon(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'Waadby Payment' AND o.current_state <> 6 AND o.current_state <> 7)) AS AMAZON_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioGrupon(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'Groupon' AND o.current_state <> 6 AND o.current_state <> 7 )) AS GROUPON_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioEmbargos(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'EMBARGOS' AND o.current_state <> 6 AND o.current_state <> 7)) AS EMBARGOS_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioMequedoUno(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT round(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            o.payment = 'MEQUEDOUNO' AND o.current_state <> 6 AND o.current_state <> 7) AS MEQUEDOUNO_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioFnac(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'Fnac MarketPlace' AND o.current_state <> 6 AND o.current_state <> 7)) AS FNAC_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioWish(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.id_customer = '242380' AND o.current_state <> 6 AND o.current_state <> 7)) AS WISH_SUMA"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioMakro(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'Makro' AND o.current_state <> 6 AND o.current_state <> 7)) AS MAKRO_SUMA"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioPcComponenetes(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'PcComponentes' AND o.current_state <> 6 AND o.current_state <> 7)) AS PcCOMPOMENTES_SUMA"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioSprinter(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'Sprinter' AND o.current_state <> 6 AND o.current_state <> 7)) AS SPRINTER_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function sumatorioBulevip(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw('week(hg_orders.date_add,7) AS semana'),
                                    DB::raw('YEAR(hg_orders.date_add) AS year_'),
                                    DB::raw('COUNT(hg_orders.id_order) AS tot_ped'),
                                    DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA'),
                                    DB::raw("(SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND WEEK(hg_orders.date_add) = WEEK(o.date_add) AND
                                            (o.payment = 'BuleVip' AND o.current_state <> 6 AND o.current_state <> 7)) AS BULEVIP_SUM"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('YEAR(hg_orders.date_add)'),'>',DB::raw('2020 AND eo.send_ok = 1 AND week(hg_orders.date_add) > WEEK(NOW())-52'))
                        ->groupBy(DB::raw('WEEK(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('WEEK(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }


        /**FUNCIONES GENERALES DE CATEGORIAS EN LA VISTA DE IMPORTE POR CATEGORIA**/
        function categoriasPorMeses(){

            $resultado = DB::table('hg_category AS cat')
                ->select(   'cat.id_category','cl.name',
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("(SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=',0)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);
        }

        function categoriaIdPorMeses($idCategory){

            $resultado = DB::table('hg_category AS cat')
                        ->select(   'cat.id_category','cl.name',
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where('cat.id_category','=',$idCategory)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);
        }

        function categoriasGeneral(){

            $resultado = DB::table('hg_category AS cat')
                        ->select('cat.id_category')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->where(DB::raw("(SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                        WHERE o6.date_add >= '2019-01-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                        GROUP BY p6.id_category_default)"),'!=',0)
                        ->orderBy('cat.id_category','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function categoriasPorTiendas($variable){

            $tienda = '';

            switch($variable){
                case 1:
                    $tienda = 'ORION91';
                    break;
                case 2:
                    $tienda = 'Manomano';
                    break;
                case 3:
                    $tienda = 'Carrefour';
                    break;
                case 4:
                    $tienda = 'AliExpress Payment';
                    break;
                case 5:
                    $tienda = 'Waadby Payment';
                    break;
                case 6:
                    $tienda = 'Groupon';
                    break;
                case 7:
                    $tienda = 'EMBARGOS';
                    break;
                case 8:
                    $tienda = 'MEQUEDOUNO';
                    break;
                case 9:
                    $tienda = 'Fnac MarketPlace';
                    break;
                case 10:
                    $tienda = '242380';
                    break;
                case 11:
                    $tienda = 'Makro';
                    break;
                case 12:
                    $tienda = 'PcComponentes';
                    break;
                case 13:
                    $tienda = 'Sprinter';
                    break;
            }

            $resultado = DB::table('hg_category AS cat')
                ->select(   'cat.id_category','cl.name',
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                            GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                            GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                            GROUP BY p6.id_category_default),0) AS 'Media2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("(SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=',0)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);
        }

        function categoriaIdPorMesesPorTienda($variableTienda,$idCategory){

            $tienda = '';

            switch($variableTienda){
                case 1:
                    $tienda = 'ORION91';
                    break;
                case 2:
                    $tienda = 'Manomano';
                    break;
                case 3:
                    $tienda = 'Carrefour';
                    break;
                case 4:
                    $tienda = 'AliExpress Payment';
                    break;
                case 5:
                    $tienda = 'Waadby Payment';
                    break;
                case 6:
                    $tienda = 'Groupon';
                    break;
                case 7:
                    $tienda = 'EMBARGOS';
                    break;
                case 8:
                    $tienda = 'MEQUEDOUNO';
                    break;
                case 9:
                    $tienda = 'Fnac MarketPlace';
                    break;
                case 10:
                    $tienda = '242380';
                    break;
                case 11:
                    $tienda = 'Makro';
                    break;
                case 12:
                    $tienda = 'PcComponentes';
                    break;
                case 13:
                    $tienda = 'Sprinter';
                    break;
            }


            $resultado = DB::table('hg_category AS cat')
                        ->select(   'cat.id_category','cl.name',
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.payment = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.payment = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.payment = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.payment = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.payment = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where('cat.id_category','=',$idCategory)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);
        }


        /**FUNCIONES PARA LA TIENDA ORION LA VISTA DE IMPORTE POR CATEGORIA**/
        function categoriasPorTiendaOrion(){

            $resultado = DB::table('hg_category AS cat')
                ->select('cat.id_category','cl.name',
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))


                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("   (SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=',0)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);
        }

        function categoriaPorTiendaOrionPorIdCategoria($idCategory){

            $resultado = DB::table('hg_category AS cat')
                ->select('cat.id_category','cl.name',
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                        INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                        INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                            WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                            AND (o2.payment = 'Pago con tarjeta Redsys' OR o2.payment = 'Redsys BBVA' OR o2.payment = 'Paga Fraccionado' OR o2.payment = 'Sequra - Pago flexible' OR  o2.payment = 'Bizum - Pago online' or o2.payment = 'PayPal' OR o2.payment = 'Transferencia bancaria' AND o2.current_state <> 6 AND o2.current_state <> 7)
                                            GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                        INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                        INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                            WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                            AND (o3.payment = 'Pago con tarjeta Redsys' OR o3.payment = 'Redsys BBVA' OR o3.payment = 'Paga Fraccionado' OR o3.payment = 'Sequra - Pago flexible' OR  o3.payment = 'Bizum - Pago online' or o3.payment = 'PayPal' OR o3.payment = 'Transferencia bancaria' AND o3.current_state <> 6 AND o3.current_state <> 7)
                                            GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                        INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                        INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                            WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                            AND (o4.payment = 'Pago con tarjeta Redsys' OR o4.payment = 'Redsys BBVA' OR o4.payment = 'Paga Fraccionado' OR o4.payment = 'Sequra - Pago flexible' OR  o4.payment = 'Bizum - Pago online' or o4.payment = 'PayPal' OR o4.payment = 'Transferencia bancaria' AND o4.current_state <> 6 AND o4.current_state <> 7)
                                            GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                        INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                        INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                            WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                            AND (o5.payment = 'Pago con tarjeta Redsys' OR o5.payment = 'Redsys BBVA' OR o5.payment = 'Paga Fraccionado' OR o5.payment = 'Sequra - Pago flexible' OR  o5.payment = 'Bizum - Pago online' or o5.payment = 'PayPal' OR o5.payment = 'Transferencia bancaria' AND o5.current_state <> 6 AND o5.current_state <> 7)
                                            GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                            DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            AND (o6.payment = 'Pago con tarjeta Redsys' OR o6.payment = 'Redsys BBVA' OR o6.payment = 'Paga Fraccionado' OR o6.payment = 'Sequra - Pago flexible' OR  o6.payment = 'Bizum - Pago online' or o6.payment = 'PayPal' OR o6.payment = 'Transferencia bancaria' AND o6.current_state <> 6 AND o6.current_state <> 7)
                                            GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))


                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("   (SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=',DB::raw("0 AND cat.id_category = $idCategory"))
                ->get();

            return response()->json($resultado);

        }


        /**FUNCIONES PARA LA TIENDA WISH LA VISTA DE IMPORTE POR CATEGORIA**/
        function categoriasPorTiendaWish(){

            $tienda = "242380";

            $resultado = DB::table('hg_category AS cat')
                        ->select(   'cat.id_category','cl.name',
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO20201 FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer= '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("(SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=',0)
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);


        }

        function categoriaPorTiendaWishPorIdCategoria($idCategory){

            $tienda = "242380";

            $resultado = DB::table('hg_category AS cat')
                        ->select(   'cat.id_category','cl.name',
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2022-01-01 0:00:00' AND o2.date_add <= '2022-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2022-02-01 0:00:00' AND o3.date_add <= '2022-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2022-03-01 0:00:00' AND o4.date_add <= '2022-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2022-04-01 0:00:00' AND o5.date_add <= '2022-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-05-01 0:00:00' AND o6.date_add <= '2022-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-06-01 0:00:00' AND o6.date_add <= '2022-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-07-01 0:00:00' AND o6.date_add <= '2022-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-08-01 0:00:00' AND o6.date_add <= '2022-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-09-01 0:00:00' AND o6.date_add <= '2022-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-10-01 0:00:00' AND o6.date_add <= '2022-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-11-01 0:00:00' AND o6.date_add <= '2022-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2022-12-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2021-01-01 0:00:00' AND o2.date_add <= '2021-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2021-02-01 0:00:00' AND o3.date_add <= '2021-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2021-03-01 0:00:00' AND o4.date_add <= '2021-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2021-04-01 0:00:00' AND o5.date_add <= '2021-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-05-01 0:00:00' AND o6.date_add <= '2021-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-06-01 0:00:00' AND o6.date_add <= '2021-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-07-01 0:00:00' AND o6.date_add <= '2021-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-08-01 0:00:00' AND o6.date_add <= '2021-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-09-01 0:00:00' AND o6.date_add <= '2021-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-10-01 0:00:00' AND o6.date_add <= '2021-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-11-01 0:00:00' AND o6.date_add <= '2021-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2021-12-01 0:00:00' AND o6.date_add <= '2021-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2021'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od2.total_price_tax_incl),2) FROM hg_order_detail AS od2
                                                INNER JOIN hg_product AS p2 ON p2.id_product = od2.product_id
                                                INNER JOIN hg_orders AS o2 ON o2.id_order = od2.id_order
                                                    WHERE o2.date_add >= '2020-01-01 0:00:00' AND o2.date_add <= '2020-01-30 23:23:59' AND o2.valid = 1 AND p2.id_category_default = cat.id_category
                                                    AND o2.id_customer = '".$tienda."' AND o2.current_state <> 6 AND o2.current_state <> 7
                                                    GROUP BY p2.id_category_default),0) AS 'ENERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od3.total_price_tax_incl),2) FROM hg_order_detail AS od3
                                                INNER JOIN hg_product AS p3 ON p3.id_product = od3.product_id
                                                INNER JOIN hg_orders AS o3 ON o3.id_order = od3.id_order
                                                    WHERE o3.date_add >= '2020-02-01 0:00:00' AND o3.date_add <= '2020-02-30 23:23:59' AND o3.valid = 1 AND p3.id_category_default = cat.id_category
                                                    AND o3.id_customer = '".$tienda."' AND o3.current_state <> 6 AND o3.current_state <> 7
                                                    GROUP BY p3.id_category_default),0) AS 'FEBRERO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od4.total_price_tax_incl),2) FROM hg_order_detail AS od4
                                                INNER JOIN hg_product AS p4 ON p4.id_product = od4.product_id
                                                INNER JOIN hg_orders AS o4 ON o4.id_order = od4.id_order
                                                    WHERE o4.date_add >= '2020-03-01 0:00:00' AND o4.date_add <= '2020-03-30 23:23:59' AND o4.valid = 1 AND p4.id_category_default = cat.id_category
                                                    AND o4.id_customer = '".$tienda."' AND o4.current_state <> 6 AND o4.current_state <> 7
                                                    GROUP BY p4.id_category_default),0) AS 'MARZO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od5.total_price_tax_incl),2) FROM hg_order_detail AS od5
                                                INNER JOIN hg_product AS p5 ON p5.id_product = od5.product_id
                                                INNER JOIN hg_orders AS o5 ON o5.id_order = od5.id_order
                                                    WHERE o5.date_add >= '2020-04-01 0:00:00' AND o5.date_add <= '2020-04-30 23:23:59' AND o5.valid = 1 AND p5.id_category_default = cat.id_category
                                                    AND o5.id_customer = '".$tienda."' AND o5.current_state <> 6 AND o5.current_state <> 7
                                                    GROUP BY p5.id_category_default),0) AS 'ABRIL2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-05-01 0:00:00' AND o6.date_add <= '2020-05-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'MAYO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-06-01 0:00:00' AND o6.date_add <= '2020-06-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JUNIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-07-01 0:00:00' AND o6.date_add <= '2020-07-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'JULIO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-08-01 0:00:00' AND o6.date_add <= '2020-08-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'AGOSTO2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-09-01 0:00:00' AND o6.date_add <= '2020-09-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'SEPTIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-10-01 0:00:00' AND o6.date_add <= '2020-10-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer= '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'OCTUBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-11-01 0:00:00' AND o6.date_add <= '2020-11-30 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'NOVIEMBRE2020'"),
                                    DB::raw("   IFNULL((SELECT round(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                                INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                                INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                                    WHERE o6.date_add >= '2020-12-01 0:00:00' AND o6.date_add <= '2020-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                                    AND o6.id_customer = '".$tienda."' AND o6.current_state <> 6 AND o6.current_state <> 7
                                                    GROUP BY p6.id_category_default),0) AS 'DICIEMBRE2020'"))
                ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                ->where(    DB::raw("(SELECT ROUND(SUM(od6.total_price_tax_incl),2) FROM hg_order_detail AS od6
                                        INNER JOIN hg_product AS p6 ON p6.id_product = od6.product_id
                                        INNER JOIN hg_orders AS o6 ON o6.id_order = od6.id_order
                                            WHERE o6.date_add >= '2020-01-01 0:00:00' AND o6.date_add <= '2022-12-31 23:23:59' AND o6.valid = 1 AND p6.id_category_default = cat.id_category
                                            GROUP BY p6.id_category_default)"),'!=', DB::raw("0 AND cat.id_category = $idCategory"))
                ->orderBy('cat.id_category','ASC')
                ->get();

            return response()->json($resultado);

        }


        /** FUNCIONES PARA VENTA DE PRODUCTOS **/
        function ventaProductos($idProducto, $fechaInicio, $fechaFin, $tienda){

            switch($tienda){
                case 1:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR  o.payment = 'Bizum - Pago online'
                            or o.payment = 'PayPal' OR o.payment = 'Transferencia bancaria' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 2:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Manomano' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 3:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Carrefour' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 4:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'AliExpress Payment' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 5:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Waadby Payment' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 6:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Groupon' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 7:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'EMBARGOS' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 8:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'MEQUEDOUNO' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 9:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Fnac MarketPlace' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 10:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.id_customer = '242380' AND o.current_state <> 6 AND o.current_state <> 7 )"))
                        ->get();
                    break;
                case 11:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Makro' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 12:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'PcComponentes' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 13:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'Sprinter' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
                case 14:
                    $resultado = DB::table('hg_orders AS o')
                        ->select(   'o.id_order','od.product_id','pl.name','od.product_quantity',
                                    DB::raw('round(od.total_price_tax_incl,2) AS importeVendido'),'o.date_add','o.payment')
                        ->join('hg_order_detail AS od','od.id_order','=','o.id_order')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('od.product_id AND pl.id_lang = 1'))
                        ->where('od.product_id' , '=', DB::raw("$idProducto AND  o.date_add >= '$fechaInicio 0:00:00' AND o.date_add <= '$fechaFin 23:23:59' AND o.valid = 1 AND
                                (o.payment = 'BuleVip' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->get();
                    break;
            }

            return response()->json($resultado);
        }


        /** FUNCION PARA CONTROLAR VENTAS SEMANALES **/
        function ventasSemanales(){

            $resultado = DB::table('hg_orders')
                        ->select(   DB::raw("DAY(hg_orders.date_add) AS dia"),
                                    DB::raw("MONTH(hg_orders.date_add) AS mes"),
                                    DB::raw("YEAR(hg_orders.date_add) AS amo"),
                                    DB::raw("COUNT(hg_orders.id_order) AS tot_ped, CONCAT(round(SUM(hg_orders.total_paid),2),'€') AS tot_sum_IVA"),
                                    DB::raw("CONCAT(ROUND(SUM(hg_orders.total_paid_tax_excl),2),'€') AS tot_SIN_IVA"),
                                    DB::raw("CONCAT(ROUND(SUM(hg_orders.total_paid)/(COUNT(hg_orders.id_order)),2),'€') AS tot_med_carr"),
                                    DB::raw("CONCAT(ELT(WEEKDAY(hg_orders.date_add) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS dia_SEMANA"),
                                    DB::raw("(SELECT count(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                            AND HOUR(o.date_add)>= 0 AND HOUR(o.date_add) <6) AS 'media06'"),
                                    DB::raw("(SELECT count(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                            AND HOUR(o.date_add)>= 6 AND HOUR(o.date_add) <12) AS 'media12'"),
                                    DB::raw("(SELECT count(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                            AND HOUR(o.date_add)>= 12 AND HOUR(o.date_add) <18) AS 'media18'"),
                                    DB::raw("(SELECT count(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                            AND HOUR(o.date_add)>= 18 AND HOUR(o.date_add) <24) AS 'media24'"),
                                    DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                            AND o.id_customer <> '107584' AND (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible'
                                            OR o.payment = 'Bizum' OR o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Pago por transferencia bancaria') AND o.current_state <> 6
                                            AND o.current_state <> 7 AND o.valid = 1 AND o.reference NOT LIKE 'INCI-%') AS ORION91"),
                                    DB::raw("CONCAT((SELECT round(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' or o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR o.payment = 'Bizum' OR o.payment = 'Bizum - Pago online' or o.payment = 'PayPal'
                                            OR o.payment = 'Pago por transferencia bancaria') AND o.current_state <> 6 AND o.current_state <> 7 and o.valid = 1 AND o.reference NOT LIKE 'INCI-%'),'€') AS ORION91_SUM"),
                                    DB::raw("CONCAT(ROUND(((SELECT round(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' or o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR o.payment = 'Bizum' OR o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Pago por transferencia bancaria') AND o.current_state <> 6 AND o.current_state <> 7 and o.valid = 1 AND o.reference NOT LIKE 'INCI-%')/
                                            (SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND DAY(o.date_add) = DAY(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR o.payment = 'Bizum' OR o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Pago por transferencia bancaria') AND o.current_state <> 6 AND o.current_state <> 7 AND o.valid = 1 AND o.reference NOT LIKE 'INCI-%')),2),'€') AS MEDIAORION91"),
                                    DB::raw("(SELECT COUNT(o2.id_order) FROM hg_orders AS o2
                                                INNER JOIN hg_ewax_orders AS ew_o ON ew_o.id_order = o2.id_order
                                                    WHERE TIMESTAMPDIFF(DAY,date(o2.date_add),date(hg_orders.date_add)) = 7
                                                    AND o2.reference NOT LIKE 'INCI-%' AND ew_o.send_ok = 1 ) AS tot_ped_7"),
                                    DB::raw("Round((SUM(hg_orders.total_paid) *100)/(SELECT SUM(o2.total_paid) FROM hg_orders AS o2
                                                INNER JOIN hg_ewax_orders AS ew_o ON ew_o.id_order = o2.id_order
                                                    WHERE TIMESTAMPDIFF(DAY,date(o2.date_add),date(hg_orders.date_add)) = 7 AND o2.reference NOT LIKE 'INCI-%'
                                                    AND ew_o.send_ok = 1)-100,2) AS porcentaje"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('(TIMESTAMPDIFF(DAY,date(hg_orders.date_add),date(NOW())))'),'<',DB::raw("21 AND hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1"))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }


        /** FUNCIONES PARA CONTROLAR COMBINADOS PREDETERMINADAS SIN STOCK**/
        function CombinadospredeterminadosSinStock(){

            $resultado = DB::table('hg_stock_available AS sa')
                        ->select(   'p.id_product','pa.id_product_attribute','pl.name','pa.default_on',"sa.quantity AS cantidad_combinacion",
                                    DB::raw("(SELECT sum(sa1.quantity) FROM hg_stock_available AS sa1 WHERE sa1.id_product = sa.id_product GROUP BY sa1.id_product, sa1.id_product_attribute LIMIT 1) AS 'total_producto'"),
                                    DB::raw("CONCAT('https://orion91.com/admin753tbd1ux/index.php/sell/catalog/products/',p.id_product) AS url"))
                        ->join('hg_product_attribute AS pa','pa.id_product_attribute','=','sa.id_product_attribute')
                        ->join('hg_product AS p','p.id_product','=','sa.id_product')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('sa.id_product AND pl.id_lang = 1'))
                        ->where('sa.quantity','=', 0)
                        ->where('sa.id_product_attribute','!=',0)
                        ->where('p.active','=',1)
                        ->where('pa.default_on','=',1)
                        ->where('pa.quantity','<=',0)
                        ->where(DB::raw('(SELECT sum(sa1.quantity) FROM hg_stock_available AS sa1 WHERE sa1.id_product = sa.id_product GROUP BY sa1.id_product)'),'>',0)
                        ->groupBy('p.id_product')
                        ->get();

            return response()->json($resultado);
        }

        function CombinadospredeterminadosSinStockCount(){

            $resultado = DB::table('hg_stock_available AS sa')
                        ->select(   'p.id_product','pa.id_product_attribute','pl.name','pa.default_on',"sa.quantity AS cantidad_combinacion",
                                    DB::raw("(SELECT sum(sa1.quantity) FROM hg_stock_available AS sa1 WHERE sa1.id_product = sa.id_product GROUP BY sa1.id_product, sa1.id_product_attribute LIMIT 1) AS 'total_producto'"))
                        ->join('hg_product_attribute AS pa','pa.id_product_attribute','=','sa.id_product_attribute')
                        ->join('hg_product AS p','p.id_product','=','sa.id_product')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('sa.id_product AND pl.id_lang = 1'))
                        ->where('sa.quantity','=', 0)
                        ->where('sa.id_product_attribute','!=',0)
                        ->where('p.active','=',1)
                        ->where('pa.default_on','=',1)
                        ->where('pa.quantity','<=',0)
                        ->where(DB::raw('(SELECT sum(sa1.quantity) FROM hg_stock_available AS sa1 WHERE sa1.id_product = sa.id_product GROUP BY sa1.id_product)'),'>',0)
                        ->groupBy('p.id_product')
                        ->get();

            return response()->json(count($resultado));
        }


        /**FUNCIONES PARA LA PARTE DE CATEGORIAS POR MESES SEGUN OPCIONES**/
        function categoriasPorOpciones($idCategory, $fechaInicio, $fechaFin, $opcion){

            $resultado = '';

            switch($opcion){
                case 1:
                    $resultado = DB::table('hg_category_product AS cp')
                                ->select('od.product_id'
                                        ,'pl.name'
                                        ,DB::raw("SUM(od.product_quantity) AS 'productosVendidos'")
                                        ,DB::raw("ROUND(SUM(od.total_price_tax_incl),2) AS 'TotalVentas'"))
                                ->join('hg_order_detail AS od','od.product_id','=','cp.id_product')
                                ->join('hg_orders AS o','o.id_order','=','od.id_order')
                                ->join('hg_product_lang AS pl','pl.id_lang','=',DB::raw('1 AND pl.id_product = od.product_id'))
                                ->where('cp.id_category','=',$idCategory)
                                ->where('o.date_add','>=',$fechaInicio)
                                ->where('o.date_add','<=',$fechaFin)
                                ->groupBy('od.product_id')
                                ->get();
                    break;
                case 2:
                    $resultado = DB::table('hg_category_product AS cp')
                                ->select('od.product_id'
                                        ,DB::raw("o.payment AS 'canal'")
                                        ,'pl.name'
                                        ,DB::raw("sum(od.product_quantity) AS 'cantidadVendida'")
                                        ,DB::raw("ROUND(SUM(od.total_price_tax_incl),2) AS 'totalVenta'"))
                                ->join('hg_order_detail AS od','od.product_id','=','cp.id_product')
                                ->join('hg_orders AS o','o.id_order','=','od.id_order')
                                ->join('hg_product_lang AS pl','pl.id_lang','=',DB::raw('1 AND pl.id_product = od.product_id'))
                                ->where('cp.id_category','=',$idCategory)
                                ->where('o.date_add','>=',$fechaInicio)
                                ->where('o.date_add','<=',$fechaFin)
                                ->groupBy('o.payment','od.product_id')
                                ->get();
                    break;
                case 3:
                    $resultado = DB::table('hg_category_product AS cp')
                                ->select(DB::raw("o.payment AS 'canal'")
                                        ,DB::raw("SUM(od.product_quantity) AS 'cantidadVendida'")
                                        ,DB::raw("ROUND(SUM(od.total_price_tax_incl),2) AS 'totalVendido'"))
                                ->join('hg_order_detail AS od','od.product_id','=','cp.id_product')
                                ->join('hg_orders AS o','o.id_order','=','od.id_order')
                                ->join('hg_product_lang AS pl','pl.id_lang','=',DB::raw('1 AND pl.id_product = od.product_id'))
                                ->where('cp.id_category','=',$idCategory)
                                ->where('o.date_add','>=',$fechaInicio)
                                ->where('o.date_add','<=',$fechaFin)
                                ->groupBy('o.payment')
                                ->get();
                    break;
            }

            return response()->json($resultado);

        }

        /**FUNCIÓN ROTURA DE STOCK**/
        function roturaStock(){

            $resultado = DB::table('hg_product as p')
                        ->select('p.id_product'
                                ,DB::raw("IFNULL(pa.id_product_attribute,'Sin IdAtributo') AS id_product_attribute")
                                ,DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13')
                                ,DB::raw('IFNULL(pa.reference, p.reference) AS reference')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen")
                                ,"pl.name AS producto"
                                ,DB::raw("agl.name AS atributo")
                                ,DB::raw("al.name AS 'valor_att'")
                                ,DB::raw('IFNULL(stock_a.quantity, stock.quantity) AS stock')
                                ,DB::raw("IFNULL((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 30 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id),0) AS ud_30_dias")
                                ,DB::raw("IFNULL(ROUND((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 30 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id)/30,2),0) AS m_30")
                                ,DB::raw("IFNULL(ROUND((IFNULL(stock_a.quantity, stock.quantity) / ((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 30 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id)/30)),2),0) AS 'rotura_en'")
                                ,DB::raw("IFNULL((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 60 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id),0) AS ud_60_dias")
                                ,DB::raw("IFNULL(ROUND((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 60 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id)/60,2),0) AS m_60")
                                ,DB::raw("IFNULL(ROUND((IFNULL(stock_a.quantity, stock.quantity) / ((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 60 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                                GROUP BY od90.product_id, od90.product_attribute_id)/60)),2),0) AS 'rotura_en_60'"))
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute as att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang as pl','pl.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang as al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute as a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang as agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_stock_available AS stock','stock.id_product','=','p.id_product')
                        ->leftJoin('hg_stock_available AS stock_a','stock_a.id_product_attribute','=',DB::raw('pa.id_product_attribute AND stock_a.id_product = p.id_product'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where('p.active','=',DB::raw('1 AND IFNULL(stock_a.quantity, stock.quantity) > 0
                                                            AND IFNULL(stock_a.quantity, stock.quantity) <=
                                                            (SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                                                INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                                                WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 30 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0)
                                                                GROUP BY od90.product_id, od90.product_attribute_id)'))
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy(DB::raw('ROUND((IFNULL(stock_a.quantity, stock.quantity) / ((SELECT SUM(od90.product_quantity) FROM hg_order_detail AS od90
                                            INNER JOIN hg_orders AS o90 ON o90.id_order = od90.id_order
                                            WHERE TIMESTAMPDIFF(DAY,o90.date_add,NOW()) <= 30 AND od90.product_id = p.id_product AND od90.product_attribute_id = ifnull(pa.id_product_attribute,0) AND o90.valid = 1
                                            GROUP BY od90.product_id, od90.product_attribute_id)/30)),2)'),'ASC')
                        ->get();

            return response()->json($resultado);
        }


        /**Función porcentajes transportistas**/
        function porcentajeTransportistas(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw("date_format(hg_orders.date_add, '%d-%m-%Y') AS date")
                                ,DB::raw("week(hg_orders.date_add,7) AS week")
                                ,DB::raw("COUNT(hg_orders.id_order) AS total")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%paa%' AND o.valid = 1 AND o.current_state = 4) AS paack")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%gls%' AND o.valid = 1 AND o.current_state = 4) AS gls")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%Tolosa%' AND o.valid = 1 AND o.current_state = 4) AS Tolosa")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%envia%'  AND o.valid = 1 AND o.current_state = 4) AS Envialia")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)  AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%tipsa%'  AND o.valid = 1 AND o.current_state = 4) AS Tipsa")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            LEFT JOIN hg_carrier AS carr ON carr.id_carrier = o.id_carrier
                                                WHERE  YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add)   AND DAY(o.date_add) = DAY(hg_orders.date_add)
                                                AND carr.name LIKE '%seur%' AND o.valid = 1 AND o.current_state = 89) AS Seur"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=',DB::raw('hg_orders.id_order WHERE DATEDIFF(NOW(), hg_orders.date_add) < 30
                                                                                    AND hg_orders.valid = 1 AND (hg_orders.current_state = 4  OR hg_orders.current_state = 89)'))
                        ->groupBy(DB::raw('day(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw("YEAR(hg_orders.date_add)"),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'), 'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'), 'DESC')
                        ->get();

            return response()->json($resultado);
        }

        /**Funcion Arbol Categorias**/
        function arbolCategorias(){

            $arrayPrincipales = array('idCategory'=>2,'name'=>'Inicio','value'=>2,'children'=>array());

            $resultado1 = DB::table('hg_category AS cat')
                        ->select('cat.id_category','catl.name')
                        ->join('hg_category_lang AS catl','catl.id_category','=',DB::raw('cat.id_category AND catl.id_lang = 1'))
                        ->where('cat.id_parent','=',2)
                        ->get();

            //LLenamos el array Principales
            for($principales = 0 ; $principales < count($resultado1); $principales++){
                $arrayTmp = array('idCategory' => $resultado1[$principales]->id_category ,'name' => $resultado1[$principales]->name, 'value' => $resultado1[$principales]->id_category , 'children' => array());
                array_push($arrayPrincipales['children'],$arrayTmp);
            }

            //LLenamos el segundo array de hijos
            for($b = 0 ; $b < count($arrayPrincipales['children']); $b++){

                $resultado2 = DB::table('hg_category AS cat')
                            ->select('cat.id_category','catl.name','cat.id_parent')
                            ->join('hg_category_lang AS catl','catl.id_category','=',DB::raw('cat.id_category AND catl.id_lang = 1'))
                            ->where('cat.id_parent','=',$arrayPrincipales['children'][$b]['idCategory'])
                            ->get();

                    for($hijos1 = 0; $hijos1 < count($resultado2); $hijos1++){
                        $arrayTmp2 = array('idCategory'=>$resultado2[$hijos1]->id_category,'name' => $resultado2[$hijos1]->name, 'value' => $resultado2[$hijos1]->id_category , 'children' => array());
                        array_push($arrayPrincipales['children'][$b]['children'],$arrayTmp2);
                    }


                //Llenamos el tercer array de hijos
                for($c = 0 ; $c < count($arrayPrincipales['children'][$b]['children']) ; $c++){

                    $resultado3 = DB::table('hg_category AS cat')
                                ->select('cat.id_category','catl.name','cat.id_parent')
                                ->join('hg_category_lang AS catl','catl.id_category','=',DB::raw('cat.id_category AND catl.id_lang = 1'))
                                ->where('cat.id_parent','=',$arrayPrincipales['children'][$b]['children'][$c]['idCategory'])
                                ->get();

                        for($hijos2 = 0 ; $hijos2 < count($resultado3); $hijos2++){
                            $arratTmp3 = array('idCategory' => $resultado3[$hijos2]->id_category, 'name' => $resultado3[$hijos2]->name, 'value' => $resultado3[$hijos2]->id_category,'children' => []);
                            array_push($arrayPrincipales['children'][$b]['children'][$c]['children'],$arratTmp3);
                        }


                    //Llenamos el cuarto array de hijos
                    for($d = 0 ; $d < count($arrayPrincipales['children'][$b]['children'][$c]['children']); $d++){

                        $resultado4 = DB::table('hg_category AS cat')
                                    ->select('cat.id_category','catl.name','cat.id_parent')
                                    ->join('hg_category_lang AS catl','catl.id_category','=',DB::raw('cat.id_category AND catl.id_lang = 1'))
                                    ->where('cat.id_parent','=',$arrayPrincipales['children'][$b]['children'][$c]['children'][$d]['idCategory'])
                                    ->get();

                            for($hijos3 = 0; $hijos3 < count($resultado4); $hijos3++){
                                $arrayTmp4 = array('idCategory'=>$resultado4[$hijos3]->id_category,'name' => $resultado4[$hijos3]->name, 'value' => $resultado4[$hijos3]->id_category);
                                array_push($arrayPrincipales['children'][$b]['children'][$c]['children'][$d]['children'],$arrayTmp4);
                            }

                    }

                }


            }



                return response()->json($arrayPrincipales);
                // return response()->json($arrayPrincipales[0]['idCategory']);

        }


        /**Ventas Semanales Todas las tiendas**/
        function ventasSemanalesTodasLasTiendas(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw('day(hg_orders.date_add) AS dia')
                                ,DB::raw('MONTH(hg_orders.date_add) AS mes')
                                ,DB::raw('YEAR(hg_orders.date_add) AS year')
                                ,DB::raw('COUNT(hg_orders.id_order) AS tot_ped')
                                ,DB::raw('round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA')
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR o.payment = 'Bizum' or o.payment = 'PayPal' OR o.payment = 'Pago por transferencia bancaria')) AS ORION91")
                                ,DB::raw("IFNULL((SELECT round(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND o.id_customer <> '107584' AND
                                            (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' or o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR o.payment = 'Bizum' or o.payment = 'PayPal' OR o.payment = 'Pago por transferencia bancaria')),0) AS ORION91_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Manomano')) AS MANOMANO")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Manomano')),0) AS MANOMANO_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'AliExpress Payment')) AS ALIEXPRESS")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'AliExpress Payment')),0) AS ALIEXPRESS_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Waadby Payment')) AS AMAZON")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Waadby Payment')),0) AS AMAZON_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Groupon')) AS GROUPON")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Groupon')),0) AS GROUPON_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'EMBARGOS')) AS EMBARGOS")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'EMBARGOS')),0) AS EMBARGOS_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'MEQUEDOUNO')) AS MEQUEDOUNO")
                                ,DB::raw("IFNULL((SELECT round(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'MEQUEDOUNO')),0) AS MEQUEDOUNO_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Fnac MarketPlace')) AS FNAC")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Fnac MarketPlace')),0) AS FNAC_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.id_customer = '242380')) AS WISH")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.id_customer = '242380')),0) AS WISH_SUMA")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Carrefour')) AS CARREFOUR")
                                ,DB::raw("IFNULL((SELECT ROUND(SUM(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Carrefour')),0) AS CARREFOUR_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add)AND (o.payment = 'Makro')) AS MAKRO")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Makro')),0) AS MAKRO_SUMA")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'PcComponentes')) AS PcCOMPONENTES")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'PcComponentes')),0) AS PcCOMPOMENTES_SUMA")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Sprinter')) AS SPRINTER")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Sprinter')),0) AS SPRINTER_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'BuleVip')) AS BULEVIP")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'BuleVip')),0) AS BULEVIP_SUM")
                                ,DB::raw("(SELECT COUNT(o.id_order) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Venca')) AS VENCA")
                                ,DB::raw("IFNULL((SELECT ROUND(sum(o.total_paid),2) FROM hg_orders AS o
                                            WHERE YEAR(o.date_add) = YEAR(hg_orders.date_add) AND MONTH(o.date_add) = MONTH(hg_orders.date_add) AND Day(o.date_add) = Day(hg_orders.date_add) AND (o.payment = 'Venca')),0) AS VENCA_SUM"))

                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('(TIMESTAMPDIFF(DAY,hg_orders.date_add,NOW()))'),'<',DB::raw("9 AND hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1"))
                        ->groupBy(DB::raw('DAY(hg_orders.date_add)'),DB::raw('month(hg_orders.date_add)'),DB::raw('YEAR (hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('day(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }


        /**Ventas Habitantes**/
        function ventasHabitantes(){

            $resultado = DB::table('ng_ventasHabitantes AS ve')
                        ->select('ve.region','ve.ciudad','ve.poblacion','ve.cod_prov'
                                ,DB::raw('ROUND(ve.totalVentas,2) AS totalVentas')
                                ,DB::raw('ROUND(ve.sumaventas,2) AS sumaventas')
                                ,DB::raw('ROUND(ve.porcentajeVentas,2) AS porcentajeVentas')
                                ,DB::raw('ROUND(ve.ventaPorHabitante,2) AS ventaPorHabitante')
                                ,'ve.latitud','ve.longitud')
                        ->orderBy('ve.ciudad','ASC')
                        ->get();

            return response()->json($resultado);
        }

        /**Funciones del DashBoard**/
        function avanceSemanal(){

            $resultado = DB::table('hg_orders AS o')
                        ->select(DB::raw('round(SUM(o.total_paid),2) AS sum_importe_hoy')
                                ,DB::raw("(SELECT round(SUM(hg_orders.total_paid),2)
                                            FROM hg_orders
                                            INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1) AS sum_importe_7")
                                ,DB::raw("ROUND(-100+(SUM(o.total_paid)*100)/(SELECT round(SUM(hg_orders.total_paid),2)
                                                                                FROM hg_orders
                                                                                INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                                                    WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1),2) AS porcentajeImporte")
                                ,DB::raw("(SELECT count(hg_orders.id_order)
                                            FROM hg_orders
                                                INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1) AS count_ped_hoy")
                                ,DB::raw("(SELECT count(hg_orders.id_order)
                                            FROM hg_orders
                                            INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1) AS count_ped_7")
                                ,DB::raw("ROUND(-100+ (SELECT count(hg_orders.id_order)
                                                        FROM hg_orders
                                                        INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                            WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1)
                                            *100/(SELECT count(hg_orders.id_order)
                                                                FROM hg_orders
                                                                INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                                    WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1),2) AS porcentajeCount_7")
                                ,DB::raw("ROUND(SUM(o.total_paid) / (SELECT count(hg_orders.id_order)
                                                                        FROM hg_orders
                                                                        INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                                            WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1),2) AS carr_med_hoy")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid)
                                                FROM hg_orders
                                                INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                    WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1)/
                                                (SELECT count(hg_orders.id_order)
                                                    FROM hg_orders
                                                    INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                        WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1),2) AS carr_med_7")
                                ,DB::raw("ROUND(-100+(SUM(o.total_paid)/
                                (SELECT count(hg_orders.id_order)
                                    FROM hg_orders
                                    INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                        WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1) *100) /
                                ((SELECT SUM(hg_orders.total_paid)
                                        FROM hg_orders
                                        INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                            WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1)/
                                                (SELECT count(hg_orders.id_order)
                                                    FROM hg_orders
                                                    INNER JOIN hg_ewax_orders ON hg_ewax_orders.id_order = hg_orders.id_order
                                                        WHERE TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 7 AND hg_orders.reference NOT LIKE 'INCI-%' AND hg_ewax_orders.send_ok = 1)),2) AS carritoPorcentaje"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','o.id_order')
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, date(o.date_add), date(NOW()))'),'=',DB::raw("0 AND o.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1"))
                        ->get();

            return response()->json($resultado);
        }

        function graficoVentas(){

            $resultado = DB::table('hg_orders AS o')
                        ->select(DB::raw('ROUND(SUM(o.total_paid),2) AS totalhoy')
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Orion")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0)/SUM(o.total_paid)),2) AS 'PorcentajeOrion'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),2) AS Sum_Amazon")
                                ,DB::raw("ROUND((100* (SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0)/SUM(o.total_paid)),2) AS 'porcentajeAmazon'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Makro")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0)/SUM(o.total_paid)),2) AS 'porcentajeMakro'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Manomano")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0)/SUM(o.total_paid)),2) AS 'porcentajeManomano'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Aliexpress")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 )/SUM(o.total_paid)),2) AS 'porcentajeAliexpress'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Wortem")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2) AS 'porcentajeWortem'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0),2) AS Sum_Carrefour")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2) AS 'porcentajeCarrefour'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Embargos")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeEmbargos'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_MequedoUno")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMequedoUno'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Sprinter")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeSprinter'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Bulevip")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeBulevip'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Venca")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeVenca'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Fnac")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeFnac'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_MediaMarkt")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMediaMarkt'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_PcComponentes")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajePcComponentes'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ),0),2) AS Sum_Wish")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) = 0 ) /SUM(o.total_paid)),2),0) AS 'porcentajeWish'"))
                ->where(DB::raw('TIMESTAMPDIFF(DAY, date(o.date_add), date(NOW()))'),'=',0)
                ->get();

            return response()->json($resultado);
        }

        function graficoVentasUnaSemana(){

            $resultado = DB::table('hg_orders AS o')
                        ->select(DB::raw('ROUND(SUM(o.total_paid),2) AS totalhoy')
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Orion")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7)/SUM(o.total_paid)),2) AS 'PorcentajeOrion'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),2) AS Sum_Amazon")
                                ,DB::raw("ROUND((100* (SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7)/SUM(o.total_paid)),2) AS 'porcentajeAmazon'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Makro")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7)/SUM(o.total_paid)),2) AS 'porcentajeMakro'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Manomano")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7)/SUM(o.total_paid)),2) AS 'porcentajeManomano'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Aliexpress")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 )/SUM(o.total_paid)),2) AS 'porcentajeAliexpress'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Wortem")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2) AS 'porcentajeWortem'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7),2) AS Sum_Carrefour")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2) AS 'porcentajeCarrefour'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Embargos")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeEmbargos'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_MequedoUno")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMequedoUno'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Sprinter")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeSprinter'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Bulevip")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeBulevip'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Venca")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeVenca'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Fnac")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeFnac'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_MediaMarkt")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMediaMarkt'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_PcComponentes")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajePcComponentes'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ),0),2) AS Sum_Wish")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 7 ) /SUM(o.total_paid)),2),0) AS 'porcentajeWish'"))
                ->where(DB::raw('TIMESTAMPDIFF(DAY, date(o.date_add), date(NOW()))'),'<=',7)
                ->get();

            return response()->json($resultado);
        }

        function graficoVentasUnMes(){

            $resultado = DB::table('hg_orders AS o')
                        ->select(DB::raw('ROUND(SUM(o.total_paid),2) AS totalhoy')
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Orion")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE (hg_orders.payment = 'Pago con tarjeta Redsys' OR hg_orders.payment = 'Redsys BBVA' OR hg_orders.payment = 'Paga Fraccionado' OR hg_orders.payment = 'Sequra - Pago flexible' OR hg_orders.payment = 'Bizum - Pago online' or hg_orders.payment = 'PayPal' OR hg_orders.payment = 'Pago por transferencia bancaria')
                                            AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30)/SUM(o.total_paid)),2) AS 'PorcentajeOrion'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),2) AS Sum_Amazon")
                                ,DB::raw("ROUND((100* (SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Waadby Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30)/SUM(o.total_paid)),2) AS 'porcentajeAmazon'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Makro")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Makro' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30)/SUM(o.total_paid)),2) AS 'porcentajeMakro'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Manomano")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Manomano' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30)/SUM(o.total_paid)),2) AS 'porcentajeManomano'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Aliexpress")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Aliexpress Payment' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 )/SUM(o.total_paid)),2) AS 'porcentajeAliexpress'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Wortem")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Worten' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2) AS 'porcentajeWortem'")
                                ,DB::raw("ROUND((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30),2) AS Sum_Carrefour")
                                ,DB::raw("ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Carrefour' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2) AS 'porcentajeCarrefour'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Embargos")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'EMBARGOS' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeEmbargos'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_MequedoUno")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MEQUEDOUNO' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMequedoUno'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Sprinter")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Sprinter' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeSprinter'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Bulevip")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Bulevip' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeBulevip'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Venca")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Venca' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeVenca'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Fnac")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'Fnac MarketPlace' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeFnac'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_MediaMarkt")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'MediaMarkt' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeMediaMarkt'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_PcComponentes")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'PcComponentes' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajePcComponentes'")
                                ,DB::raw("ROUND(IFNULL((SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ),0),2) AS Sum_Wish")
                                ,DB::raw("IFNULL(ROUND((100*(SELECT SUM(hg_orders.total_paid) FROM hg_orders WHERE hg_orders.payment = 'WISH' AND TIMESTAMPDIFF(DAY, date(hg_orders.date_add), date(NOW())) <= 30 ) /SUM(o.total_paid)),2),0) AS 'porcentajeWish'"))
                ->where(DB::raw('TIMESTAMPDIFF(DAY, date(o.date_add), date(NOW()))'),'<=',30)
                ->get();

            return response()->json($resultado);
        }

        function ventasSemanalesDashBoard(){

            $resultado = DB::table('hg_orders')
                        ->select(DB::raw("CONCAT(CONCAT(CONCAT(CONCAT(DAY(hg_orders.date_add),'/'),MONTH(hg_orders.date_add)),'/'),YEAR(hg_orders.date_add)) AS fecha")
                                ,DB::raw('COUNT(hg_orders.id_order) AS tot_ped')
                                ,DB::raw("round(SUM(hg_orders.total_paid),2) AS tot_sum_IVA")
                                ,DB::raw("ROUND((SUM(hg_orders.total_paid) *100)/(SELECT SUM(o2.total_paid) FROM hg_orders AS o2
                                            INNER JOIN hg_ewax_orders AS ew_o ON ew_o.id_order = o2.id_order
                                                WHERE TIMESTAMPDIFF(DAY,date(o2.date_add),date(hg_orders.date_add)) = 7 AND o2.reference NOT LIKE 'INCI-%'
                                                AND ew_o.send_ok = 1)-100,2) AS porcentaje"))
                        ->join('hg_ewax_orders AS eo','eo.id_order','=','hg_orders.id_order')
                        ->where(DB::raw('(TIMESTAMPDIFF(DAY,date(hg_orders.date_add),date(NOW())))'),'<',DB::raw("7 AND hg_orders.reference NOT LIKE 'INCI-%' AND eo.send_ok = 1"))
                        ->groupBy(DB::raw('DAY(hg_orders.date_add)'),DB::raw('MONTH(hg_orders.date_add)'),DB::raw('YEAR(hg_orders.date_add)'))
                        ->orderBy(DB::raw('YEAR(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('MONTH(hg_orders.date_add)'),'DESC')
                        ->orderBy(DB::raw('DAY(hg_orders.date_add)'),'DESC')
                        ->get();

            return response()->json($resultado);
        }

        function roturaDeStock(){

            $resultado = DB::table('ng_historico_stock AS st')
                        ->select('st.id_producto','st.id_atributo','st.ean13','pl.name','st.fecha_actualizacion','st.stock AS stock_hoy'
                                ,'ayer.stock AS stock_hoy_1','ante_ayer.stock AS stock_hoy_2','ante_ante_ayer.stock AS stock_hoy_3'
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('ng_historico_stock AS ayer','ayer.ean13','=','st.ean13')
                        ->join('ng_historico_stock AS ante_ayer','ante_ayer.ean13','=','st.ean13')
                        ->join('ng_historico_stock AS ante_ante_ayer','ante_ante_ayer.ean13','=','st.ean13')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('st.id_producto AND pl.id_lang = 1'))
                        ->leftJoin('hg_image_shop AS image_shop','image_shop.id_product','=',DB::raw('st.id_producto AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, date(st.fecha_actualizacion), date(NOW()))'),'=',DB::raw('0 AND st.stock = 0'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, date(ayer.fecha_actualizacion), date(NOW()))'),'=',DB::raw('1 AND ayer.stock > 0'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, date(ante_ayer.fecha_actualizacion), date(NOW()))'),'=',DB::raw('2 AND ante_ayer.stock > 0'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, date(ante_ante_ayer.fecha_actualizacion), date(NOW()))'),'=',DB::raw('3 AND ante_ante_ayer.stock > 0'))
                        ->get();

            return response()->json($resultado);
        }

        function graficoVentasPaisesHoy(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('pais.name',DB::raw('ROUND(SUM(o.total_paid),2) AS total'))
                        ->join('hg_address AS ad','ad.id_address','=','o.id_address_delivery')
                        ->join('hg_country_lang AS pais','pais.id_country','=',DB::raw('ad.id_country AND pais.id_lang = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, DATE(o.date_add), date(NOW()))'),'<=',DB::raw('0 AND o.valid = 1'))
                        ->groupBy('ad.id_country')
                        ->get();

            return response()->json($resultado);
        }

        function graficoVentasPaisesUnaSemana(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('pais.name',DB::raw('ROUND(SUM(o.total_paid),2) AS total'))
                        ->join('hg_address AS ad','ad.id_address','=','o.id_address_delivery')
                        ->join('hg_country_lang AS pais','pais.id_country','=',DB::raw('ad.id_country AND pais.id_lang = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, DATE(o.date_add), date(NOW()))'),'<=',DB::raw('7 AND o.valid = 1'))
                        ->groupBy('ad.id_country')
                        ->get();

            return response()->json($resultado);
        }

        function graficoVentasPaisesUnMes(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('pais.name',DB::raw('ROUND(SUM(o.total_paid),2) AS total'))
                        ->join('hg_address AS ad','ad.id_address','=','o.id_address_delivery')
                        ->join('hg_country_lang AS pais','pais.id_country','=',DB::raw('ad.id_country AND pais.id_lang = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, DATE(o.date_add), date(NOW()))'),'<=',DB::raw('30 AND o.valid = 1'))
                        ->groupBy('ad.id_country')
                        ->get();

            return response()->json($resultado);
        }

        function graficoComparacionVentas(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('o.date_add',DB::raw('YEAR(o.date_add) AS amo'),DB::raw('ROUND(SUM(o.total_paid),2) AS total'))
                        ->where(DB::raw("o.reference NOT LIKE 'INCI%' AND o.valid"),'=',DB::raw('1 AND YEAR(o.date_add) >= 2021'))
                        ->groupBy(DB::raw('MONTHNAME(o.date_add)'),DB::raw('YEAR(o.date_add)'))
                        ->orderBy('o.date_add','ASC')
                        ->get();

            return response()->json($resultado);
        }

    }

?>
