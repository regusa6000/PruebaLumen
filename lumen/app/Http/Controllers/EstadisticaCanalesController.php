<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;

    class EstadisticaCanalesController extends Controller{

        //Fechas Hoy
        function productosTopCanales($variable){

            $tienda = '';

            switch($variable){
                case 1:
                    $tienda = 'ORION91';
                    break;
                case 2:
                    $tienda = 'Waadby Payment';
                    break;
                case 3:
                    $tienda = 'Makro';
                    break;
                case 4:
                    $tienda = 'Manomano';
                    break;
                case 5:
                    $tienda = 'AliExpress Payment';
                    break;
                case 6:
                    $tienda = 'Worten';
                    break;
                case 7:
                    $tienda = 'Carrefour';
                    break;
                case 8:
                    $tienda = 'EMBARGOS';
                    break;
                case 9:
                    $tienda = 'MEQUEDOUNO';
                    break;
                case 10:
                    $tienda = 'Sprinter';
                    break;
                case 11:
                    $tienda = 'Bulevip';
                    break;
                case 12:
                    $tienda = 'Venca';
                    break;
                case 13:
                    $tienda = 'Fnac MarketPlace';
                    break;
                case 14:
                    $tienda = '242380';
                    break;
                case 15:
                    $tienda = 'MediaMarktSaturno';
                    break;
                case 16:
                    $tienda = 'PcComponentes';
                    break;
                case 17:
                    $tienda = 'VIPALIA';
                    break;
            }

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'=',DB::raw(" 0 AND o.payment = '". $tienda ."' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalOrion(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'=',DB::raw(" 0 AND (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR  o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Transferencia bancaria' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalWish(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'=',DB::raw("0 AND o.id_customer = '242380' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        //Ultimos 15 dias
        function productosTopCanales15Dias($variable){

            $tienda = '';

            switch($variable){
                case 1:
                    $tienda = 'ORION91';
                    break;
                case 2:
                    $tienda = 'Waadby Payment';
                    break;
                case 3:
                    $tienda = 'Makro';
                    break;
                case 4:
                    $tienda = 'Manomano';
                    break;
                case 5:
                    $tienda = 'AliExpress Payment';
                    break;
                case 6:
                    $tienda = 'Worten';
                    break;
                case 7:
                    $tienda = 'Carrefour';
                    break;
                case 8:
                    $tienda = 'EMBARGOS';
                    break;
                case 9:
                    $tienda = 'MEQUEDOUNO';
                    break;
                case 10:
                    $tienda = 'Sprinter';
                    break;
                case 11:
                    $tienda = 'Bulevip';
                    break;
                case 12:
                    $tienda = 'Venca';
                    break;
                case 13:
                    $tienda = 'Fnac MarketPlace';
                    break;
                case 14:
                    $tienda = '242380';
                    break;
                case 15:
                    $tienda = 'MediaMarktSaturno';
                    break;
                case 16:
                    $tienda = 'PcComponentes';
                    break;
                case 17:
                    $tienda = 'VIPALIA';
                    break;
            }

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw(" 15 AND o.payment = '". $tienda ."' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalOrion15Dias(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw(" 15 AND (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR  o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Transferencia bancaria' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalWish15Dias(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw("15 AND o.id_customer = '242380' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        //Ultimos 30 dias
        function productosTopCanales30Dias($variable){

            $tienda = '';

            switch($variable){
                case 1:
                    $tienda = 'ORION91';
                    break;
                case 2:
                    $tienda = 'Waadby Payment';
                    break;
                case 3:
                    $tienda = 'Makro';
                    break;
                case 4:
                    $tienda = 'Manomano';
                    break;
                case 5:
                    $tienda = 'AliExpress Payment';
                    break;
                case 6:
                    $tienda = 'Worten';
                    break;
                case 7:
                    $tienda = 'Carrefour';
                    break;
                case 8:
                    $tienda = 'EMBARGOS';
                    break;
                case 9:
                    $tienda = 'MEQUEDOUNO';
                    break;
                case 10:
                    $tienda = 'Sprinter';
                    break;
                case 11:
                    $tienda = 'Bulevip';
                    break;
                case 12:
                    $tienda = 'Venca';
                    break;
                case 13:
                    $tienda = 'Fnac MarketPlace';
                    break;
                case 14:
                    $tienda = '242380';
                    break;
                case 15:
                    $tienda = 'MediaMarktSaturno';
                    break;
                case 16:
                    $tienda = 'PcComponentes';
                    break;
                case 17:
                    $tienda = 'VIPALIA';
                    break;
            }

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw(" 30 AND o.payment = '". $tienda ."' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalOrion30Dias(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw(" 30 AND (o.payment = 'Pago con tarjeta Redsys' OR o.payment = 'Redsys BBVA' OR o.payment = 'Paga Fraccionado' OR o.payment = 'Sequra - Pago flexible' OR  o.payment = 'Bizum - Pago online' or o.payment = 'PayPal' OR o.payment = 'Transferencia bancaria' AND o.current_state <> 6 AND o.current_state <> 7)"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

        function productosTopCanalWish30Dias(){

            $resultado = DB::table('hg_order_detail AS od')
                        ->select('p.id_product','pl.name','cl.name AS nombre_cat'
                                ,DB::raw('SUM(od.product_quantity) AS suma_cantidad')
                                ,DB::raw('ROUND(sum(od.total_price_tax_incl),2) AS suma_importes')
                                ,DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->join('hg_orders AS o','o.id_order','=','od.id_order')
                        ->join('hg_product AS p','p.id_product','=','od.product_id')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_category AS cat','cat.id_category','=','p.id_category_default')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cat.id_category AND cl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where(DB::raw('TIMESTAMPDIFF (DAY, date(o.date_add), date(NOW()))'),'<=',DB::raw("30 AND o.id_customer = '242380' AND o.current_state <> 6 AND o.current_state <> 7"))
                        ->groupBy('p.id_product')
                        ->orderBy(DB::raw('SUM(od.total_price_tax_incl)'),'DESC')
                        ->limit(10)
                        ->get();

            return response()->json($resultado);
        }

    }

?>
