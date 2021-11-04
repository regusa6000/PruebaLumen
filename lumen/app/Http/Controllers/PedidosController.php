<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;

class PedidosController extends Controller{

        function controlPedidosAlmacen(){

            $resultado = DB::table('hg_orders')
                        ->select('*')
                        ->join('hg_ewax_orders','hg_orders.id_order','=','hg_ewax_orders.id_order')
                        ->where('hg_ewax_orders.send_ok','!=',DB::raw("1 and (hg_orders.current_state = 2 OR hg_orders.current_state = 89 OR (hg_orders.current_state = 1 AND hg_orders.payment = 'Pago con tarjeta Redsys')) AND TIMESTAMPDIFF(DAY,hg_orders.date_add,NOW()) < 30"))

                        ->get();

            return response()->json($resultado);
        }

        function controlPedidosPagados(){

            $resultado = DB::table('hg_orders')
                        ->select('hg_orders.id_order',
                                    DB::raw('ROUND(hg_orders.total_paid,2) as total_paid'),
                                    'hg_order_payment.amount',
                                    DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount as diferencia'),
                                    'hg_orders.reference','hg_orders.payment','hg_orders.current_state','hg_orders.date_add')
                        ->leftJoin('hg_order_payment','hg_orders.reference','=','hg_order_payment.order_reference')
                        ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'<>',
                                DB::raw("ROUND(hg_orders.total_shipping,2)
                                AND ROUND(hg_orders.total_paid,2) - hg_order_payment.amount > 0.1
                                AND TIMESTAMPDIFF(DAY,hg_orders.date_add, NOW()) < 10
                                AND hg_orders.payment <> 'Pagos por transferencia bancaria'
                                AND hg_orders.current_state <> 6"))
                        ->orderBy('hg_orders.id_order','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function controlPedidosPagadosBadge(){

            $resultado = DB::table('hg_orders')
                        ->select('hg_orders.id_order',
                                    DB::raw('ROUND(hg_orders.total_paid,2) as total_paid'),
                                    'hg_order_payment.amount',
                                    DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount as diferencia'),
                                    'hg_orders.reference','hg_orders.payment','hg_orders.current_state','hg_orders.date_add')
                        ->leftJoin('hg_order_payment','hg_orders.reference','=','hg_order_payment.order_reference')
                        ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'<>',
                                DB::raw("ROUND(hg_orders.total_shipping,2)
                                AND ROUND(hg_orders.total_paid,2) - hg_order_payment.amount > 0.1
                                AND TIMESTAMPDIFF(DAY,hg_orders.date_add, NOW()) < 10
                                AND hg_orders.payment <> 'Pagos por transferencia bancaria'
                                AND hg_orders.current_state <> 6"))
                        ->orderBy('hg_orders.id_order','DESC')
                        ->get();

            return response()->json(count($resultado));

        }

        function controlHistoricoStock($id_producto){

            $resultado = DB::table('ng_historico_stock as h')
                        ->select('h.id_producto','l.name','h.id_atributo','h.fecha_actualizacion','h.stock')
                        ->join('hg_product_lang as l','h.id_producto','=','l.id_product')
                        ->where('h.id_producto','=',$id_producto)
                        ->groupBy('h.fecha_actualizacion')
                        ->orderBy('h.id_resgistro','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function controlHistoricoStockAtributo($id_atributo){

            $resultado = DB::table('ng_historico_stock as h')
                        ->select('h.id_producto','l.name','h.id_atributo','agl.name AS grupo','al.name AS valor','h.fecha_actualizacion','h.stock')
                        ->join('hg_product_lang AS l','h.id_producto','=','l.id_product')
                        ->leftJoin('hg_product_attribute AS pa','h.id_atributo','=','pa.id_product_attribute')
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang as al','pac.id_attribute','=', DB::raw('al.id_attribute AND al.id_lang = 1'))
                        ->leftJoin('hg_attribute as a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang as agl','a.id_attribute_group','=',DB::raw('agl.id_attribute_group AND agl.id_lang = 1'))
                        ->where('h.id_atributo','=',$id_atributo)
                        ->groupBy('h.fecha_actualizacion')
                        ->orderBy('h.id_resgistro','DESC')
                        ->get();

            return response()->json($resultado);
        }


        function controlHistoricoStockTotal($id_producto,$id_atributo){

            $resultado = DB::table('ng_historico_stock')
                    ->select('*')
                    ->where('ng_historico_stock.id_producto','=',$id_producto)
                    ->where('ng_historico_stock.id_atributo','=',$id_atributo)
                    ->orderBy('ng_historico_stock.id_resgistro','DESC')
                    ->get();

            return response()->json($resultado);
        }


        //Funciones para el grafico
        function controlStockGraficoIdProducto($idProducto){

            $variables = [];

            for($a = 0 ; $a < 20 ; $a++){

                $resultado = DB::table('ng_historico_stock AS p')
                        ->where('p.id_producto','=',DB::raw($idProducto.' and date(p.fecha_actualizacion) = (SELECT MAX(DATE_SUB(date(a.fecha_actualizacion), INTERVAL '.$a.' DAY))
                        FROM ng_historico_stock AS a WHERE a.id_producto ='.$idProducto.')'))
                        ->groupBy('p.id_producto')
                        ->get();

                array_push($variables, $resultado);
            }

            return response()->json( array_reverse($variables));
        }

        function controlStockGraficoIdAtributo($idAtributo){

            $variables = [];

            for($a = 0 ; $a < 20 ; $a++){

                $resultado = DB::table('ng_historico_stock AS p')
                        ->where('p.id_atributo','=',DB::raw($idAtributo.' and date(p.fecha_actualizacion) = (SELECT MAX(DATE_SUB(date(a.fecha_actualizacion), INTERVAL '.$a.' DAY))
                        FROM ng_historico_stock AS a WHERE a.id_atributo ='.$idAtributo.')'))
                        ->groupBy('p.id_atributo')
                        ->get();

                array_push($variables, $resultado);
            }

            return response()->json( array_reverse($variables));
        }

        function controlStockGraficoTotal($idProducto,$idAtributo){

            $variables = [];

            for($a = 0 ; $a < 20 ; $a++){

                $resultado = DB::table('ng_historico_stock AS p')
                        ->where('p.id_producto','=',DB::raw($idProducto.' and p.id_atributo = '.$idAtributo.' and date(p.fecha_actualizacion) = (SELECT MAX(DATE_SUB(date(a.fecha_actualizacion), INTERVAL '.$a.' DAY))
                        FROM ng_historico_stock AS a WHERE a.id_producto ='.$idProducto.' and a.id_atributo = '.$idAtributo.')'))
                        ->groupBy('p.id_producto')
                        ->get();

                array_push($variables, $resultado);
            }

            return response()->json( array_reverse($variables));
        }


        function controlCategoriasVacias(){

            $resultado = DB::table('hg_category as c')
                        ->select(   'c.id_category','cl.name','c.active','clpadre.name as padre',
                                    DB::raw('CONCAT("https://orion91.com/", cl.link_rewrite) as urlOrigen'),
                                    DB::raw('(SELECT COUNT(hg_category_product.id_category) FROM hg_category_product
                                                INNER JOIN hg_product ON hg_product.id_product = hg_category_product.id_product
                                                WHERE hg_category_product.id_category = c.id_category AND hg_product.active = 1) AS contador'),
                                    DB::raw('IF((SELECT count(hg_lgseoredirect.id) FROM hg_lgseoredirect WHERE hg_lgseoredirect.url_old = CONCAT("/",cl.link_rewrite))>0,"SI","NO") AS redirigida'))
                        ->join('hg_category_lang AS cl','cl.id_category','=','c.id_category')
                        ->join('hg_category_lang AS clpadre','clpadre.id_category','=','c.id_parent')
                        ->where('cl.id_lang','=',DB::raw('1 AND clpadre.id_lang = 1 AND c.active = 1 AND
                                    (SELECT COUNT(hg_category_product.id_category) FROM hg_category_product
                                    INNER JOIN hg_product ON hg_product.id_product = hg_category_product.id_product
                                    WHERE hg_category_product.id_category = c.id_category AND hg_product.active = 1) = 0 AND c.id_category <> 2'))
                        ->having('redirigida', '=' ,'NO')
                        ->orderBy('contador')
                        ->get();

            return response()->json($resultado);
        }

        function controlCategoriasVaciasContador(){

            $resultado = DB::table('hg_category as c')
                        ->select(   'c.id_category','cl.name','c.active','clpadre.name as padre',
                                    DB::raw('CONCAT("https://orion91.com/", cl.link_rewrite) as urlOrigen'),
                                    DB::raw('(SELECT COUNT(hg_category_product.id_category) FROM hg_category_product
                                                INNER JOIN hg_product ON hg_product.id_product = hg_category_product.id_product
                                                WHERE hg_category_product.id_category = c.id_category AND hg_product.active = 1) AS contador'),
                                    DB::raw('IF((SELECT count(hg_lgseoredirect.id) FROM hg_lgseoredirect WHERE hg_lgseoredirect.url_old = CONCAT("/",cl.link_rewrite))>0,"SI","NO") AS redirigida'))
                        ->join('hg_category_lang AS cl','cl.id_category','=','c.id_category')
                        ->join('hg_category_lang AS clpadre','clpadre.id_category','=','c.id_parent')
                        ->where('cl.id_lang','=',DB::raw('1 AND clpadre.id_lang = 1 AND c.active = 1 AND
                                    (SELECT COUNT(hg_category_product.id_category) FROM hg_category_product
                                    INNER JOIN hg_product ON hg_product.id_product = hg_category_product.id_product
                                    WHERE hg_category_product.id_category = c.id_category AND hg_product.active = 1) = 0 AND c.id_category <> 2'))
                        ->having('redirigida', '=' ,'NO')
                        ->orderBy('contador')
                        ->get();

            return response()->json(count($resultado));
        }

        function controlPreCompras(){

            $resultado = DB::table('hg_stock_available')
                        ->select('hg_stock_available.id_product','hg_stock_available.out_of_stock','hg_product_lang.name','hg_product_lang.available_later','hg_stock_available.quantity')
                        ->join('hg_product_lang','hg_stock_available.id_product','=','hg_product_lang.id_product')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_stock_available.out_of_stock','=',1)
                        ->get();

            return response()->json($resultado);
        }

        function controlTransportistas(){

            $resultado = DB::table('hg_orders AS o')
                        ->select('o.id_order','o.reference','col.name',DB::raw('YEAR(o.date_add)'),DB::raw('(CASE
                                        WHEN o.payment = "Pagos por transferencia bancaria" then "ORION91"
                                        WHEN o.payment = "Paypal" then "ORION91"
                                        WHEN o.payment = "Pago con tarjeta Redsys" then "ORION91"
                                        WHEN o.payment = "Paga Fraccionado" then "ORION91"
                                        WHEN o.payment = "Bizum" then "ORION91"
                                        WHEN o.payment = "AliExpress Payment" then "ALIEXPRESS"
                                        WHEN o.payment = "FNAC MarketPlace" then "FNAC"
                                        WHEN o.payment = "Waadby Payment" AND SUBSTRING(o.gift_message, -3) = "MFN" then "AMAZON PRIME"
                                        WHEN o.payment = "Waadby Payment" AND SUBSTRING(o.gift_message, -3) <> "MFN" then "AMAZON"
                                        ELSE UPPER(o.payment)
                                        END) AS origenPed'),'carrier.name', 'o.date_add AS fechaCreado', 'oh.date_add AS fechaEnviado',
                                        DB::raw('TIMESTAMPDIFF(hour,o.date_add,oh.date_add) AS horasHastaEnviado'), 'oh_entregado.date_add AS fechaEntregado',
                                        DB::raw('TIMESTAMPDIFF(hour,oh.date_add,oh_entregado.date_add) AS horasHastaEntregado'),
                                        DB::raw('if((SELECT COUNT(*) FROM hg_order_history AS oh2 where oh2.id_order = o.id_order AND oh2.id_order_state = 9) = 0, "NO", "SI") AS PreCompra'))
                        ->join('hg_order_carrier AS oc','oc.id_order','=','o.id_order')
                        ->join('hg_carrier AS carrier','carrier.id_carrier','=','oc.id_carrier')
                        ->leftJoin('hg_order_history AS oh','oh.id_order','=',DB::raw('o.id_order AND oh.id_order_state = 4'))
                        ->leftJoin('hg_order_history AS oh_entregado','oh_entregado.id_order','=',DB::raw('o.id_order AND oh_entregado.id_order_state = 5'))
                        ->join('hg_address AS ad','ad.id_address','=','o.id_address_delivery')
                        ->join('hg_country_lang AS col','col.id_country','=',DB::raw('ad.id_country AND col.id_lang = 1'))
                        //->where(DB::raw('SUBSTRING(o.gift_message, -3) <> "MFN" AND YEAR(o.date_add) > 2020'))
                        //->groupBy('o.id_order','o.reference','col.name','o.payment','o.gift_message','carrier.name','o.date_add','oh.date_add','oh_entregado.date_add')
                        ->where('oh.date_add','!=','null')
                        ->groupBy('o.id_order')
                        ->orderBy('o.id_order','DESC')
                        ->get();

            return response()->json($resultado);
        }


        function controlTransportistasName($nameTransportista){

            $resultado = DB::table('hg_orders AS o')
                        ->select('o.id_order','o.reference','col.name',DB::raw('YEAR(o.date_add)'),DB::raw('(CASE
                                        WHEN o.payment = "Pagos por transferencia bancaria" then "ORION91"
                                        WHEN o.payment = "Paypal" then "ORION91"
                                        WHEN o.payment = "Pago con tarjeta Redsys" then "ORION91"
                                        WHEN o.payment = "Paga Fraccionado" then "ORION91"
                                        WHEN o.payment = "Bizum" then "ORION91"
                                        WHEN o.payment = "AliExpress Payment" then "ALIEXPRESS"
                                        WHEN o.payment = "FNAC MarketPlace" then "FNAC"
                                        WHEN o.payment = "Waadby Payment" AND SUBSTRING(o.gift_message, -3) = "MFN" then "AMAZON PRIME"
                                        WHEN o.payment = "Waadby Payment" AND SUBSTRING(o.gift_message, -3) <> "MFN" then "AMAZON"
                                        ELSE UPPER(o.payment)
                                        END) AS origenPed'),'carrier.name', 'o.date_add AS fechaCreado', 'oh.date_add AS fechaEnviado',
                                        DB::raw('TIMESTAMPDIFF(hour,o.date_add,oh.date_add) AS horasHastaEnviado'), 'oh_entregado.date_add AS fechaEntregado',
                                        DB::raw('TIMESTAMPDIFF(hour,oh.date_add,oh_entregado.date_add) AS horasHastaEntregado'),
                                        DB::raw('if((SELECT COUNT(*) FROM hg_order_history AS oh2 where oh2.id_order = o.id_order AND oh2.id_order_state = 9) = 0, "NO", "SI") AS PreCompra'))
                        ->join('hg_order_carrier AS oc','oc.id_order','=','o.id_order')
                        ->join('hg_carrier AS carrier','carrier.id_carrier','=','oc.id_carrier')
                        ->leftJoin('hg_order_history AS oh','oh.id_order','=',DB::raw('o.id_order AND oh.id_order_state = 4'))
                        ->leftJoin('hg_order_history AS oh_entregado','oh_entregado.id_order','=',DB::raw('o.id_order AND oh_entregado.id_order_state = 5'))
                        ->join('hg_address AS ad','ad.id_address','=','o.id_address_delivery')
                        ->join('hg_country_lang AS col','col.id_country','=',DB::raw('ad.id_country AND col.id_lang = 1'))
                        ->where('carrier.id_carrier','=',$nameTransportista)
                        ->groupBy('o.id_order')
                        ->orderBy('o.id_order','DESC')
                        ->get();

            return response()->json($resultado);
        }


        function manoAmano(){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        // ->where('man.division','!=',1.180000)
                        // ->where('man.division','!=',1.030000)
                        ->get();

            return response()->json($resultado);
        }

        function manoAmanoPorProducto($idProducto){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        // ->where('man.division','!=',1.180000)
                        // ->where('man.division','!=',1.030000)
                        ->where('p.id_product','=',$idProducto)
                        ->get();

            return response()->json($resultado);
        }

        function manoAmanoPorPrimero(){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        ->where('man.division','=',1.200000)
                        ->get();

            return response()->json($resultado);
        }

        function manoAmanoPorSegundo(){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        ->where('man.division','=',1.030000)
                        ->get();

            return response()->json($resultado);
        }

        function manoAmanoPorDivision(){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        ->where('man.division','!=',1.200000)
                        ->where('man.division','!=',1.030000)
                        ->where('man.division','!=',1.210000)
                        ->where('man.division','!=',1.170000)
                        ->get();

            return response()->json($resultado);
        }

        function manoAmanoPorDivisionBadge(){

            $resultado = DB::table('ng_mano_a_mano_aux AS man')
                        ->select('man.id_product','man.name',
                                DB::raw('ROUND(man.price,2) AS price'),
                                DB::raw('ROUND(man.normal_shipping_price,2) AS normal_shipping_price'),
                                DB::raw('ROUND(man.totalManoMano,2) AS totalManoMano'),
                                DB::raw('ROUND(man.division,2) AS division'),
                                DB::raw('ROUND(man.additionalShippingCostPresta,2) AS additionalShippingCostPresta'),
                                DB::raw('ROUND(man.pricePresta,2) AS pricePresta'),
                                DB::raw('ROUND(man.reductionPresta,2) AS reductionPresta'),
                                DB::raw('ROUND(man.totalOrion,2) AS totalOrion'))
                        ->join('hg_product AS p','man.id_product','=','p.id_product')
                        ->where('p.active','=',1)
                        ->where('man.division','!=',1.200000)
                        ->where('man.division','!=',1.030000)
                        ->where('man.division','!=',1.210000)
                        ->where('man.division','!=',1.170000)
                        ->get();

            return response()->json(count($resultado));
        }

        function pedidosAlmacenBadge(){

            $resultado = DB::table('hg_orders')
                        ->select('*')
                        ->join('hg_ewax_orders','hg_orders.id_order','=','hg_ewax_orders.id_order')
                        ->where('hg_ewax_orders.send_ok','!=',DB::raw("1 and (hg_orders.current_state = 2 OR hg_orders.current_state = 89 OR (hg_orders.current_state = 1 AND hg_orders.payment = 'Pago con tarjeta Redsys')) AND TIMESTAMPDIFF(DAY,hg_orders.date_add,NOW()) < 30"))
                        ->get();

            return response()->json(count($resultado));
        }


        function cargarComboName(){

            $resultado = DB::table('hg_carrier AS a')
                        ->select(DB::raw('DISTINCT(a.name), a.id_carrier'))
                        ->where('a.active','=',1)
                        ->where('a.deleted','=', 0)
                        ->get();

            return response()->json($resultado);
        }



        function registrarNoticias(Request $request){

            $imagen = $_FILES['imagen']['name'];
            $datos = json_decode($_REQUEST['datos'],true);

            $directorioFinal = "./../../../AngularAdmin/src/assets/".$imagen;
            move_uploaded_file($_FILES['imagen']['tmp_name'],$directorioFinal);

            $noticia = $datos['noticia'];
            $titulo = $datos['titulo'];
            $id_user = $_REQUEST['id_user'];
            $fecha = Carbon::now();

            $consulta = DB::table('ng_noticias')->insert([
                'id_user'=>$id_user,
                'titulo'=>$titulo,
                'noticia'=>$noticia,
                'img'=>$imagen,
                'fecha'=>$fecha
            ]);

            return $consulta;
        }

        function mostrarNoticias(){

            $resultado = DB::table('ng_noticias as n')
                        ->select('n.id_noticia','u.name','n.titulo','n.noticia','n.img','n.fecha')
                        ->join('ng_users AS u','n.id_user','=','u.id_user')
                        ->orderBy('n.fecha','DESC')
                        ->limit('5')
                        ->get();

            return response()->json($resultado);
        }

        function monstrarTodasNoticias(){

            $resultado = DB::table('ng_noticias as n')
                        ->select('n.id_noticia','n.id_noticia','u.name','n.titulo','n.noticia','n.img','n.fecha')
                        ->join('ng_users AS u','n.id_user','=','u.id_user')
                        ->orderBy('n.fecha','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function eliminarNoticia($id_noticia){

            $resultado = DB::table('ng_noticias')
                        ->where('id_noticia','=',$id_noticia)
                        ->delete();
            return $resultado;
        }

        function actualizarNoticia(Request $request){

            $id_noticia = $request->input('id_noticia');
            $titulo = $request->input('titulo');
            $noticia = $request->input('noticia');
            $img = $request->input('img');
            $fecha = $request->input('fecha');

            $resultado = DB::table('ng_noticias')
                        ->where('id_noticia','=',$id_noticia)
                        ->update([
                                'titulo'=>$titulo,
                                'noticia'=>$noticia,
                                'img'=>$img,
                                'fecha'=>$fecha
                            ]);
            return $resultado;
        }

        /*Funciones de Makro Offers*/

        function productosTotalesMakro(){

            $resultado = DB::table('aux_makro_offers AS au')
                        ->select('au.id_product','au.gtin','au.sku','au.name','au.name_att','au.name_value_att',DB::raw('ROUND(au.price,2) as price'),'au.stock','au.status','au.date')
                        ->orderBy('au.id_product','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function offersPublicados(){

            $resultado = DB::table('aux_makro_offers AS au')
                        ->select('au.id_product','au.gtin','au.sku','au.name','au.name_att','au.name_value_att',DB::raw('ROUND(au.price,2) as price'),'au.stock','au.status','au.date')
                        ->where('au.status','=',1)
                        ->orderBy('au.id_product','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function offerNoPublicados(){

            $resultado = DB::table('aux_makro_offers AS au')
                        ->select('au.id_product','au.gtin','au.sku','au.name','au.name_att','au.name_value_att',DB::raw('ROUND(au.price,2) as price'),'au.stock','au.status','au.date')
                        ->where('au.status','=',0)
                        ->orderBy('au.id_product','ASC')
                        ->get();

            return response()->json($resultado);
        }

        function offerPorIdProducto($idProduct){

            $resultado = DB::table('aux_makro_offers AS au')
                        ->select('au.id_product','au.gtin','au.sku','au.name','au.name_att','au.name_value_att',DB::raw('ROUND(au.price,2) as price'),'au.stock','au.status','au.date')
                        ->where('au.id_product','=',$idProduct)
                        ->orderBy('au.id_product','ASC')
                        ->get();

            return response()->json($resultado);
        }


        function imagenes(){

            $resultado = DB::table('hg_product as p')
                        ->select(   'p.id_product',
                                    DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13'),
                                    DB::raw('IFNULL(pa.reference, p.reference) AS ref'),
                                    'pl.name AS nombre_producto','agl.name AS nombre_atributo','al.name AS nombre_valor_att',
                                    DB::raw('IFNULL(ima_att.id_image,ima.id_image) AS id_image'),
                                    DB::raw("CONCAT('https://orion91.com/', pl.link_rewrite) as link"),
                                    'ima.position','ima.cover')
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute as att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang as pl','pl.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang as al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute as a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang as agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_image AS ima','ima.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_image AS ima_att','ima_att.id_product_attribute','=','pa.id_product_attribute')
                        ->where('p.active','=',DB::raw('1 AND ima.position = 1'))
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function imagenesName($name){

            $resultado = DB::table('hg_product as p')
                        ->select(   'p.id_product',
                                    DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13'),
                                    DB::raw('IFNULL(pa.reference, p.reference) AS ref'),
                                    'pl.name AS nombre_producto','agl.name AS nombre_atributo','al.name AS nombre_valor_att',
                                    DB::raw('IFNULL(ima_att.id_image,ima.id_image) AS id_image'),
                                    DB::raw("CONCAT('https://orion91.com/', pl.link_rewrite) as link"),
                                    'ima.position','ima.cover')
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute as att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang as pl','pl.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang as al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute as a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang as agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_image AS ima','ima.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_image AS ima_att','ima_att.id_product_attribute','=','pa.id_product_attribute')
                        ->where('p.active','=',DB::raw("1 AND pl.name LIKE '%".$name."%'") )
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function imagenesReference($reference){

            $resultado = DB::table('hg_product as p')
                        ->select(   'p.id_product',
                                    DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13'),
                                    DB::raw('IFNULL(pa.reference, p.reference) AS ref'),
                                    'pl.name AS nombre_producto','agl.name AS nombre_atributo','al.name AS nombre_valor_att',
                                    DB::raw('IFNULL(ima_att.id_image,ima.id_image) AS id_image'),
                                    DB::raw("CONCAT('https://orion91.com/', pl.link_rewrite) as link"),
                                    'ima.position','ima.cover')
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute as att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang as pl','pl.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang as al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute as a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang as agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_image AS ima','ima.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_image AS ima_att','ima_att.id_product_attribute','=','pa.id_product_attribute')
                        ->where('p.active','=',DB::raw("1 AND IFNULL(pa.reference = ".$reference.",p.reference = ".$reference.")"))
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

    }
?>
