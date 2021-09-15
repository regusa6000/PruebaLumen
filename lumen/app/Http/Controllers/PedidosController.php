<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    }

?>
