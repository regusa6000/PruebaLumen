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
                        ->where(DB::raw('hg_ewax_orders.send_ok = 0 OR null'))
                        ->where('hg_orders.current_state','=','2')
                        ->where(DB::raw('TIMESTAMPDIFF(DAY,hg_orders.date_add,NOW()) > 0'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY,hg_orders.date_add,NOW()) < 30'))
                        ->get();

            return response()->json($resultado);
        }

        function controlPedidosPagados()
        {

            $resultado = DB::table('hg_orders')
                ->select('hg_orders.id_order',DB::raw('ROUND(hg_orders.total_paid,2) as total_paid'),'hg_order_payment.amount',
                    DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount as diferencia'), 'hg_orders.reference','hg_orders.payment','hg_orders.date_add')
                ->leftJoin('hg_order_payment','hg_orders.reference','=','hg_order_payment.order_reference')
                ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'<>',DB::raw('ROUND(hg_orders.total_shipping,2)'))
                ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'>','0.1')
                ->orderBy('hg_orders.id_order','DESC')
                ->get();

            return response()->json($resultado);
        }

        function controlHistoricoStock($id_producto){

            $resultado = DB::table('ng_historico_stock')
                        ->select('*')
                        ->where('ng_historico_stock.id_producto','=',$id_producto)
                        ->orderBy('ng_historico_stock.id_resgistro','DESC')
                        ->get();
            return response()->json($resultado);
        }

        function controlCategoriasVacias(){

            $resultado = DB::table('hg_category as c')
                        ->select('c.id_category','cl.name','c.active','clpadre.name as padre',DB::raw(' CONCAT("https://orion91.com/", cl.link_rewrite) as urlOrigen'),
                                DB::raw('(SELECT  COUNT(hg_category_product.id_category) FROM hg_category_product WHERE  hg_category_product.id_category = c.id_category) AS contador'),
                                DB::raw('IF((SELECT count(hg_lgseoredirect.id) FROM hg_lgseoredirect WHERE hg_lgseoredirect.url_old = CONCAT("/",cl.link_rewrite))>0,"SI","NO") AS rediridiga'))
                        ->join('hg_category_lang AS cl','cl.id_category','=','c.id_category')
                        ->join('hg_category_lang AS clpadre','clpadre.id_category','=','c.id_parent')
                        ->where('cl.id_lang','=',1)
                        ->where('clpadre.id_lang','=',1)
                        ->where('c.active','=',1)
                        ->orderBy('contador','ASC')
                        ->get();

            return response()->json($resultado);
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
                        ->select('o.id_order','o.reference','col.name',DB::raw('(CASE
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
                        ->groupBy('o.id_order')
                        ->orderBy('o.id_order','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function registrarNoticias(Request $request){

            //FALTA PONER LA IMAGEN****
            $idUser = $request->input('idUser');
            $titulo = $request->input('titulo');
            $noticia = $request->input('noticia');
            $fecha = Carbon::now();

            $consulta = DB::table('ng_noticias')->insert([
                'id_user'=>$idUser,
                'titulo'=>$titulo,
                'noticia'=>$noticia,
                'fecha'=>$fecha
            ]);

            return response()->json($consulta);
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

    }

?>
