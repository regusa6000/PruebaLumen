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
                        ->select('abo.idFactura','abo.pedidoAx','abo.referenciaPs',DB::raw('SUM(abo.precioFinal) AS precioFinal'),'abo.fechaFactura',DB::raw('COUNT(abo.referenciaPs) AS cantidadProductos'))
                        ->where('abo.fechaFactura','>=',DB::raw("'".$fechaInicio."'"."AND abo.fechaFactura <= DATE_ADD("."'".$fechaFin."'".", INTERVAL 1 DAY)"))
                        ->groupBy('abo.idFactura')
                        ->get();

            return response()->json($resultado);
        }

        function buscarLineasAbonos(Request $request){

            $orPedido = $request->input('orPedido');

            $resultado = DB::table('ng_abonos AS abo')
                        ->select('abo.idFactura','abo.pedidoAx','abo.referenciaPs','amo.id_product','amo.name','abo.cantidadVendida'
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen")
                                ,'abo.precioFinal','abo.fechaFactura')
                        ->leftJoin('aux_makro_offers AS amo','amo.itemid','=','abo.idProductAx')
                        ->leftJoin('hg_image_shop AS image_shop','image_shop.id_product','=',DB::raw('amo.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where('abo.referenciaPs','=',$orPedido)
                        ->get();

            return response()->json($resultado);
        }

    }

?>
