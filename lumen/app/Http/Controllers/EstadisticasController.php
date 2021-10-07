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

    }

?>
