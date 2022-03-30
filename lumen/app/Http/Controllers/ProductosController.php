<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
    use Illuminate\Auth\Access\Response;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Carbon;

class ProductosController extends Controller{

        public function index ($id){

            $producto = DB::table('hg_image')
                                ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                                ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                                ->select('hg_product.id_product','hg_product_lang.name','id_product_attribute')
                                ->where('hg_product_lang.id_lang','=',1)
                                ->where('hg_product.id_product','=',$id)
                                ->get();

            $jsonResult = array();

            $jsonResult[0]['id_product'] = $producto[0]->id_product;
            $jsonResult[0]['name'] = $producto[0]->name;
            //$jsonResult[0]['id_attribute'] = $producto[0]->id_product_attribute;

            for ($a = 0 ; $a < 1 ; $a++){
                $jsonResult[$a]['attributes'] = DB::table('hg_image')
                                                ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                                                ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                                ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                                                ->select('hg_product_attribute_image.id_product_attribute','hg_image.id_image','hg_product.reference','hg_image.position')
                                                ->where('hg_product_lang.id_lang','=',1)
                                                ->where('hg_product.id_product','=',$id)
                                                ->where('hg_product.active','=',1)
                                                /*->orderBy('hg_product.id_product','ASC')
                                                ->orderBy('hg_product_attribute_image.id_product_attribute','ASC')*/
                                                //->orderBy('hg_image.position','ASC')
                                                ->orderBy('hg_image.position','ASC')
                                                ->get();

                if($producto[$a]->id_product_attribute != null){

                    $jsonResult[$a]['ax_id_combinado'] = DB::table('hg_ewax_product_attribute')
                                                        ->select('hg_ewax_product_attribute.ax_id')
                                                        ->where('hg_ewax_product_attribute.id_product_attribute','=',$producto[$a]->id_product_attribute)
                                                        ->get();

                }else{
                    $jsonResult[$a]['ax_id'] = DB::table('hg_ewax_product')
                                                ->select('hg_ewax_product.ax_id')
                                                ->where('hg_ewax_product.id_product','=',$producto[$a]->id_product)
                                                ->get();
                }


            }

            return response()->json($jsonResult);
        }

        public function principal(){

            $producto = DB::table('hg_image')
                        ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                        ->join('hg_ewax_product','hg_product.id_product','=','hg_ewax_product.id_product')
                        ->select('hg_product.id_product','hg_product_lang.name','hg_product.reference','hg_product_attribute_image.id_product_attribute', 'hg_image.id_image', 'hg_product.reference','hg_ewax_product.ax_id')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_product.active','=',1)
                        ->orderBy('hg_product.id_product','ASC')
                        ->orderBy('hg_product_attribute_image.id_product_attribute','ASC')
                        ->orderBy('hg_product_attribute_image.id_image','ASC')
                        ->get();

                for($a = 0 ; $a < count($producto); $a++) {
                    if ($producto[$a]->id_product_attribute != null) {

                        $producto[$a]['ax_id_combinado'] = DB::table('hg_ewax_product_attribute')
                            ->select('hg_ewax_product_attribute.ax_id')
                            ->where('hg_ewax_product_attribute.id_product_attribute', '=', $producto[$a]->id_product_attribute)
                            ->get();
                        $producto[$a]['stock'] = DB::table('hg_stock_available')
                            ->select('hg_stock_available.quantity')
                            ->where('hg_stock_available.id_product_attribute', '=', $producto[$a]->id_product_attribute)
                            ->get();
                    }
                        /*$producto[$a]['stock'] = DB::table('hg_stock_available')
                            ->select('hg_stock_available.quantity')
                            ->where('hg_stock_available.id_product', '=', $producto[$a]->id_product)
                            ->get();*/

                    return response()->json($producto);
                }

        }

        public function tablaError(){

            $producto = DB::table('ng_errors')
                        ->join('hg_product','ng_errors.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->select('ng_errors.id_product','hg_product_lang.name','hg_product.reference', 'ng_errors.id_image', 'hg_product.reference', 'ng_errors.id_ax')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_product.active','=',1)
                        ->where('ng_errors.error','=',1)
                        ->get();

            return response()->json($producto);
        }

        public function tablaOk(){
            $producto = DB::table('ng_errors')
                        ->join('hg_product','ng_errors.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->select('ng_errors.id_product','hg_product_lang.name','hg_product.reference', 'ng_errors.id_image', 'hg_product.reference','ng_errors.id_ax')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_product.active','=',1)
                        ->where('ng_errors.ok','=',1)
                        ->get();

            return response()->json($producto);
        }


        /**FUNCIONES CATEGORIAS REDIRECCIONADAS**/
        function categoriasRedireccionadas(){

            $resultado = DB::table('hg_category_lang AS cl')
                        ->select(DB::raw("CONCAT('https://orion91.com/', cl.link_rewrite) AS url_antigua")
                                ,'cl.id_category'
                                ,DB::raw("(SELECT redi.url_new FROM hg_lgseoredirect AS redi
                                            WHERE CONCAT('https://orion91.com',redi.url_old) = CONCAT('https://orion91.com/', cl.link_rewrite)) AS url_destino")
                                ,'p.id_product','pl.name','p.active')
                        ->leftJoin('hg_product AS p','p.id_category_default','=','cl.id_category')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->where('cl.id_lang','=',DB::raw("1 AND p.active = 1
                                                            AND (SELECT CONCAT('https://orion91.com',redi.url_old) FROM hg_lgseoredirect AS redi
                                                            WHERE CONCAT('https://orion91.com',redi.url_old) = CONCAT('https://orion91.com/', cl.link_rewrite)) IS NOT null"))
                        ->get();

            return response()->json($resultado);
        }

        function countCategoriasRedireccionadas(){

            $resultado = DB::table('hg_category_lang AS cl')
                        ->select(DB::raw("CONCAT('https://orion91.com/', cl.link_rewrite) AS url_antigua")
                                ,'cl.id_category'
                                ,DB::raw("(SELECT CONCAT('https://orion91.com',redi.url_new) FROM hg_lgseoredirect AS redi
                                            WHERE CONCAT('https://orion91.com',redi.url_old) = CONCAT('https://orion91.com/', cl.link_rewrite)) AS url_destino")
                                ,'p.id_product','pl.name','p.active')
                        ->leftJoin('hg_product AS p','p.id_category_default','=','cl.id_category')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->where('cl.id_lang','=',DB::raw("1 AND p.active = 1
                                                            AND (SELECT CONCAT('https://orion91.com',redi.url_old) FROM hg_lgseoredirect AS redi
                                                            WHERE CONCAT('https://orion91.com',redi.url_old) = CONCAT('https://orion91.com/', cl.link_rewrite)) IS NOT null"))
                        ->get();

            return count($resultado);
        }

        function controlPreciosCambiadosAx(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product'
                                ,DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13')
                                ,DB::raw('IFNULL(pa.reference, p.reference) AS reference')
                                ,DB::raw('ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) AS precioORION91')
                                ,DB::raw('round(pmp.precioOfertaAx,2) AS precioAX')
                                ,'pl.name AS nombre_producto','agl.name AS nombre_atributo','al.name AS nombre_valor_att')
                        ->leftJoin('hg_product_attribute AS pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination AS patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute AS att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_specific_price AS precio_espe_att','precio_espe_att.id_product_attribute','=',DB::raw('0
                                        AND precio_espe_att.id_product = p.id_product AND precio_espe_att.id_group = 0 AND precio_espe_att.id_customer = 0
                                        AND precio_espe_att.id_cart = 0'))
                        ->leftJoin('hg_specific_price AS precio_espe','precio_espe.id_product','=',DB::raw('p.id_product AND precio_espe.id_group = 0
                                        AND precio_espe.id_customer = 0 AND precio_espe.id_cart = 0'))
                        ->join('ng_pmp_aux AS pmp','pmp.reference','=',DB::raw('IFNULL(pa.reference, p.reference)'))
                        ->where('p.active','=',DB::raw("1 AND round(pmp.precioOfertaAx,2) <> '0.00' AND pl.name NOT LIKE '%navidad%'AND
                                                            ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) <> round(pmp.precioOfertaAx,2)"))
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function badgeControlPreciosCambiadosAx(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product'
                                ,DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13')
                                ,DB::raw('IFNULL(pa.reference, p.reference) AS reference')
                                ,DB::raw('ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) AS precioORION91')
                                ,DB::raw('round(pmp.precioOfertaAx,2) AS precioAX')
                                ,'pl.name AS nombre_producto','agl.name AS nombre_atributo','al.name AS nombre_valor_att')
                        ->leftJoin('hg_product_attribute AS pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination AS patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute AS att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_specific_price AS precio_espe_att','precio_espe_att.id_product_attribute','=',DB::raw('0
                                        AND precio_espe_att.id_product = p.id_product AND precio_espe_att.id_group = 0 AND precio_espe_att.id_customer = 0
                                        AND precio_espe_att.id_cart = 0'))
                        ->leftJoin('hg_specific_price AS precio_espe','precio_espe.id_product','=',DB::raw('p.id_product AND precio_espe.id_group = 0
                                        AND precio_espe.id_customer = 0 AND precio_espe.id_cart = 0'))
                        ->join('ng_pmp_aux AS pmp','pmp.reference','=',DB::raw('IFNULL(pa.reference, p.reference)'))
                        ->where('p.active','=',DB::raw("1 AND round(pmp.precioOfertaAx,2) <> '0.00' AND pl.name NOT LIKE '%navidad%'AND
                                                            ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) <> round(pmp.precioOfertaAx,2)"))
                        ->groupBy(DB::raw('IFNULL(pa.ean13, p.ean13)'))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json(count($resultado));
        }

        function cargarFaqs(){

            $resultado = DB::table('hg_product_faqs')
                        ->select('*')
                        ->orderBy('hg_product_faqs.date_add','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function crearFaq(Request $request){

            $idProduct = $request->input('idProduct');
            $faq = $request->input('faq');
            $fechaCreacion = Carbon::now();

            $resultado = DB::table('hg_product_faqs')
                        ->insert([
                            'id_product' => $idProduct,
                            'faq' => $faq,
                            'date_add' => $fechaCreacion
                        ]);

            return response()->json($resultado);
        }

        function actualizarFaq(Request $request){

            $idFaq = $request->input('idFaq');
            $idProduct = $request->input('idProduct');
            $fechaActualizacion = Carbon::now();
            $faq = $request->input('faq');

            $resultado = DB::table('hg_product_faqs')
                        ->where('id_product_faq','=',$idFaq)
                        ->update([
                            'id_product' => $idProduct,
                            'faq' => $faq,
                            'date_update' => $fechaActualizacion,
                        ]);

            return response()->json($resultado);
        }

        function eliminarFaq($idFaq){

            $resultado = DB::table('hg_product_faqs')
                        ->where('id_product_faq','=',$idFaq)
                        ->delete();

            return response()->json($resultado);
        }


        /**FAVORITOS**/
        function cargarTopFavoritos(){

            $resultado = DB::table('hg_ws_wishlist_product AS wh')
                        ->select('wh.id_product','pl.name',DB::raw('COUNT(wh.id_product) AS nFavoritos'),DB::raw("CONCAT('https://orion91.com/img/tmp/product_mini_',image_shop.id_image,'.jpg') AS imagen"))
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('wh.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_image_shop as image_shop','image_shop.id_product','=',DB::raw('wh.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->groupBy('wh.id_product')
                        ->orderBy(DB::raw('COUNT(wh.id_product)'),'DESC')
                        ->limit(20)
                        ->get();

            return response()->json($resultado);
        }

        function cargarGraficoFavoritos(){

            $resultado = DB::table('hg_ws_wishlist_product AS wp')
                        ->select(DB::raw('COUNT(wp.id_wishlist_product) AS contador'),'wp.fecha')
                        ->groupBy(DB::raw('DAY(wp.fecha)'),DB::raw('MONTH(wp.fecha)'),DB::raw('YEAR(wp.fecha)'))
                        ->get();

            return response()->json($resultado);
        }


    }

?>
