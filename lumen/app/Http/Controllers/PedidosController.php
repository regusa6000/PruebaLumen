<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

    class PedidosController extends Controller{

        /*function controlPedidosAlmacen(){



            $resultado = DB::table('hg_orders')
                        ->select('*')
                        ->join('hg_ewax_orders','hg_orders.id_order','=','hg_ewax_orders.id_order')
                        ->where('hg_ewax_orders.send_ok','=','0')
                        ->where('hg_orders.current_state','=','2')
                        ->get();


            $now = new Carbon();
            $diff = $now->DiffInHours($resultado[0]->date_add);
            return $resultado;

        }*/

        function ControlPedidosPagados()
        {

            $resultado = DB::table('hg_orders')
                ->select('hg_orders.id_order',DB::raw('ROUND(hg_orders.total_paid,2) as total_paid'),'hg_order_payment.amount',
                    DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount as diferencia'), 'hg_orders.reference','hg_orders.payment','hg_orders.date_add')
                ->join('hg_order_payment','hg_orders.reference','=','hg_order_payment.order_reference')
                ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'>','0.1')
                ->where(DB::raw('ROUND(hg_orders.total_paid,2) - hg_order_payment.amount'),'<>',DB::raw('ROUND(hg_orders.hg_orders.total_shipping,2)'))
                ->orderBy('hg_orders.id_order','DESC')

                ->get();

            return response()->json($resultado);
        }

    }

?>
