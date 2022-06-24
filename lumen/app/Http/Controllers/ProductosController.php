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
                        ->select('p.id_product', 'pmp.id_ax'
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

        /**BUSCADOR DE PRODUCTOS**/
        function buscadorProductos($value){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product'
                                ,DB::raw('IF(ISNULL(pa.reference), p.reference, pa.reference ) AS reference')
                                ,DB::raw('IF(ISNULL(pa.ean13), p.ean13, pa.ean13 ) AS ean13')
                                ,DB::raw("CONCAT(pl.name, ' ', ifnull(agl.name, ' '), ' ', ifnull(al.name, ' ')) AS name")
                                ,'agl.name AS atributo','al.name AS valor','ewp.ax_id AS axIdSimple','ewpatt.ax_id AS axIdCombinado'
                                ,DB::raw("CONCAT('https://orion91.com/admin753tbd1ux/index.php/sell/catalog/products/', p.id_product ,'?_token=VgQLVMbLDms771jVriCgNnFAiYkKfWS30FhPOEQ8A2s') AS url")
                                ,DB::raw("CONCAT(CONCAT(CONCAT('https://orion91.com/',
                                        IFNULL((SELECT hg_image_shop.id_image
                                                    FROM hg_product
                                                    LEFT JOIN hg_image_shop ON hg_image_shop.id_product= hg_product.id_product
                                                    LEFT JOIN hg_product_attribute_image ON hg_product_attribute_image.id_image = hg_image_shop.id_image
                                                    WHERE hg_product.id_product = p.id_product AND hg_product_attribute_image.id_product_attribute = pa.id_product_attribute
                                                    GROUP BY hg_image_shop.id_product, hg_product_attribute_image.id_product_attribute
                                                    ORDER BY hg_image_shop.id_product asc, hg_product_attribute_image.id_product_attribute ASC)

                                                ,(SELECT hg_image_shop.id_image
                                                    FROM hg_product LEFT JOIN hg_image_shop ON hg_image_shop.id_product= hg_product.id_product
                                                    WHERE hg_product.id_product = p.id_product
                                                    ORDER BY hg_image_shop.id_product ASC LIMIT 1))),'-cart_default/'),pl.link_rewrite,'.jpg') AS imagen"))
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute AS pa','p.id_product','=','pa.id_product')
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=',DB::raw('al.id_attribute AND al.id_lang = 1'))
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=',DB::raw('agl.id_attribute_group AND agl.id_lang = 1'))
                        ->leftJoin('hg_ewax_product AS ewp','ewp.id_product','=','p.id_product')
                        ->leftJoin('hg_ewax_product_attribute AS ewpatt','ewpatt.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_image_shop AS image_shop','image_shop.id_product','=',DB::raw('p.id_product AND image_shop.cover = 1 AND image_shop.id_shop = 1'))
                        ->where('p.id_product','like',DB::raw("'". $value ."%'" ."OR p.reference LIKE '". $value ."%'"."OR pa.reference LIKE '". $value
                                ."%'"."OR p.ean13 LIKE '". $value ."%'"."OR pa.ean13 LIKE '". $value ."%'"."OR ewp.ax_id LIKE '". $value ."%'"."OR ewpatt.ax_id LIKE '". $value ."%'"
                                ."OR pl.name LIKE '%". $value . "%'"."OR agl.name LIKE '%". $value . "%'"."OR al.name LIKE '%". $value . "%'"))
                        ->groupBy('p.id_product','pac.id_attribute')
                        ->get();

            return response()->json($resultado);
        }

        /**Productos sin Ean13**/
        function productosSinEan13(){

            $resultado = DB::table('hg_product as p')
                        ->select('p.id_product','ax.id_ax','pa.id_product_attribute',DB::raw('IFNULL (pa.reference, p.reference) AS reference'), 'p.date_add'
                                ,'pl.name AS nombreProducto','agl.name AS nombreAtributo','al.name AS nombreValorAtt',DB::raw('IFNULL(stock_a.quantity, stock.quantity) AS stock'))
                        ->leftJoin('hg_product_attribute AS pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination AS patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute AS att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_stock_available AS stock','stock.id_product','=','p.id_product')
                        ->leftJoin('hg_stock_available AS stock_a','stock_a.id_product_attribute','=',DB::raw('pa.id_product_attribute AND stock_a.id_product = p.id_product'))
                        ->leftJoin('ng_pmp_aux AS ax','ax.reference','=',DB::raw('IFNULL (pa.reference, p.reference)'))
                        ->where('p.active','=',DB::raw("1 AND IFNULL(pa.ean13, p.ean13) = '' AND IFNULL(stock_a.quantity, stock.quantity) > 0"))
                        ->groupBy('p.id_product','pa.id_product_attribute')
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function countProductosSinEan13(){

            $resultado = DB::table('hg_product as p')
                        ->select('p.id_product','ax.id_ax','pa.id_product_attribute',DB::raw('IFNULL (pa.reference, p.reference) AS reference'), 'p.date_add'
                                ,'pl.name AS nombreProducto','agl.name AS nombreAtributo','al.name AS nombreValorAtt',DB::raw('IFNULL(stock_a.quantity, stock.quantity) AS stock'))
                        ->leftJoin('hg_product_attribute AS pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination AS patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_attribute AS att','att.id_attribute','=','patc.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=','al.id_attribute')
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=','agl.id_attribute_group')
                        ->leftJoin('hg_stock_available AS stock','stock.id_product','=','p.id_product')
                        ->leftJoin('hg_stock_available AS stock_a','stock_a.id_product_attribute','=',DB::raw('pa.id_product_attribute AND stock_a.id_product = p.id_product'))
                        ->leftJoin('ng_pmp_aux AS ax','ax.reference','=',DB::raw('IFNULL (pa.reference, p.reference)'))
                        ->where('p.active','=',DB::raw("1 AND IFNULL(pa.ean13, p.ean13) = '' AND IFNULL(stock_a.quantity, stock.quantity) > 0"))
                        ->groupBy('p.id_product','pa.id_product_attribute')
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json(count($resultado));
        }

        /**PRODUCTOS CON POCAS IMAGENES**/
        function productosConPocasImagenes(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product','pl.name AS producto','al.name AS valorAtt','imgatt.id_product_attribute',DB::raw('COUNT(img.id_product) AS contador')
                                ,DB::raw("CONCAT(CONCAT(CONCAT('https://orion91.com/',
                                            IFNULL((SELECT hg_image_shop.id_image
                                                        FROM hg_product
                                                        LEFT JOIN hg_image_shop ON hg_image_shop.id_product= hg_product.id_product
                                                        LEFT JOIN hg_product_attribute_image ON hg_product_attribute_image.id_image = hg_image_shop.id_image
                                                        WHERE hg_product.id_product = p.id_product AND hg_product_attribute_image.id_product_attribute = imgatt.id_product_attribute
                                                        GROUP BY hg_image_shop.id_product, hg_product_attribute_image.id_product_attribute
                                                        ORDER BY hg_image_shop.id_product asc, hg_product_attribute_image.id_product_attribute ASC)

                                                    ,(SELECT hg_image_shop.id_image
                                                        FROM hg_product LEFT JOIN hg_image_shop ON hg_image_shop.id_product= hg_product.id_product
                                                        WHERE hg_product.id_product = p.id_product
                                                        ORDER BY hg_image_shop.id_product ASC LIMIT 1))),'-cart_default/'),pl.link_rewrite,'.jpg') AS imagen"))
                        ->leftJoin('hg_image_shop AS img','img.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_image AS imgatt','imgatt.id_image','=','img.id_image')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pac.id_product_attribute','=','imgatt.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','al.id_attribute','=',DB::raw('pac.id_attribute AND al.id_lang = 1'))
                        ->leftJoin('hg_attribute AS a','a.id_attribute','=','al.id_attribute')
                        ->where('p.active','=',1)
                        ->groupBy('p.id_product','imgatt.id_product_attribute')
                        ->orderBy(DB::raw('COUNT(img.id_product)'),'ASC')
                        ->get();

            return response()->json($resultado);
        }

        /**Función productos con combinaciones y precios diferentes**/
        function diferenciaPreciosCombinados(){

            $resultado = DB::table('hg_product as p')
                        ->select(DB::raw('COUNT(DISTINCT pa.price) AS distintos_precios'),'p.id_product',DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13'),DB::raw('IFNULL(pa.reference, p.reference) AS reference')
                                ,DB::raw('ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) AS precio'),'pl.name AS nombre_producto')
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=',DB::raw('al.id_attribute AND al.id_lang = 1'))
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=',DB::raw('agl.id_attribute_group AND agl.id_lang = 1'))
                        ->leftJoin('hg_specific_price AS precio_espe_att','precio_espe_att.id_product_attribute','=',DB::raw('pa.id_product_attribute AND
                                        precio_espe_att.id_product = pa.id_product AND precio_espe_att.id_group = 0 AND precio_espe_att.id_group = 0 AND precio_espe_att.id_cart = 0'))
                        ->leftJoin('hg_specific_price AS precio_espe','precio_espe.id_product','=',DB::raw('pa.id_product AND
                                        precio_espe.id_group = 0 AND precio_espe.id_group = 0 AND precio_espe.id_cart = 0'))
                        ->where('p.active','=',DB::raw("1 AND pa.id_product_attribute IS NOT NULL AND pl.name NOT LIKE '%Árbol de Navidad %'"))
                        ->groupBy('p.id_product')
                        ->orderBy('p.id_product','DESC')
                        ->get();


            $arrayDiferentes = [];

            for($a = 0 ; $a < count($resultado); $a++){
                if($resultado[$a]->distintos_precios > 1){
                    array_push($arrayDiferentes,$resultado[$a]);
                }
            }

            return response()->json($arrayDiferentes);
        }

        function badgeDiferenciaPreciosCombinados(){

            $resultado = DB::table('hg_product as p')
                        ->select(DB::raw('COUNT(DISTINCT pa.price) AS distintos_precios'),'p.id_product',DB::raw('IFNULL(pa.ean13, p.ean13) AS ean13'),DB::raw('IFNULL(pa.reference, p.reference) AS reference')
                                ,DB::raw('ROUND((IFNULL(pa.price, p.price) - IFNULL ((IFNULL(pa.price,p.price) * IFNULL(precio_espe_att.reduction, precio_espe.reduction)),0)) * 1.21,2) AS precio'),'pl.name AS nombre_producto')
                        ->leftJoin('hg_product_attribute as pa','pa.id_product','=','p.id_product')
                        ->leftJoin('hg_product_attribute_combination as patc','patc.id_product_attribute','=','pa.id_product_attribute')
                        ->leftJoin('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->leftJoin('hg_product_attribute_combination AS pac','pa.id_product_attribute','=','pac.id_product_attribute')
                        ->leftJoin('hg_attribute_lang AS al','pac.id_attribute','=',DB::raw('al.id_attribute AND al.id_lang = 1'))
                        ->leftJoin('hg_attribute AS a','al.id_attribute','=','a.id_attribute')
                        ->leftJoin('hg_attribute_group_lang AS agl','a.id_attribute_group','=',DB::raw('agl.id_attribute_group AND agl.id_lang = 1'))
                        ->leftJoin('hg_specific_price AS precio_espe_att','precio_espe_att.id_product_attribute','=',DB::raw('pa.id_product_attribute AND
                                        precio_espe_att.id_product = pa.id_product AND precio_espe_att.id_group = 0 AND precio_espe_att.id_group = 0 AND precio_espe_att.id_cart = 0'))
                        ->leftJoin('hg_specific_price AS precio_espe','precio_espe.id_product','=',DB::raw('pa.id_product AND
                                        precio_espe.id_group = 0 AND precio_espe.id_group = 0 AND precio_espe.id_cart = 0'))
                        ->where('p.active','=',DB::raw("1 AND pa.id_product_attribute IS NOT NULL AND pl.name NOT LIKE '%Árbol de Navidad %'"))
                        ->groupBy('p.id_product')
                        ->orderBy('p.id_product','DESC')
                        ->get();


            $arrayDiferentes = [];

            for($a = 0 ; $a < count($resultado); $a++){
                if($resultado[$a]->distintos_precios > 1){
                    array_push($arrayDiferentes,$resultado[$a]);
                }
            }

            return response()->json(count($arrayDiferentes));
        }

        function controlPreciosBaseMenorPrecioOferta(){

            $resultado = DB::table('ng_pmp_aux as precios')
                        ->select('precios.price','precios.precioOfertaAx','aux.itemid AS itemID_AX'
                                ,'aux.id_product AS id_PS','aux.name','aux.name_att','aux.name_value_att')
                        ->join('aux_makro_offers AS aux','aux.itemid','=','precios.id_ax')
                        ->where('aux.itemid','=',DB::raw('precios.id_ax AND precios.precioOfertaAx > precios.price'))
                        ->get();

            return response()->json($resultado);
        }

        function countControlPreciosBaseMenorPrecioOferta(){

            $resultado = DB::table('ng_pmp_aux as precios')
                        ->select('precios.price','precios.precioOfertaAx','aux.itemid AS itemID_AX'
                                ,'aux.id_product AS id_PS','aux.name','aux.name_att','aux.name_value_att')
                        ->join('aux_makro_offers AS aux','aux.itemid','=','precios.id_ax')
                        ->where('aux.itemid','=',DB::raw('precios.id_ax AND precios.precioOfertaAx > precios.price'))
                        ->get();

            return response()->json(count($resultado));
        }

        //Productos solo categorizados en OUTLET
        function productosEnCategoriaOulet(){

            $resultado = DB::table('hg_category_product AS cp')
                        ->select('cp.id_product','pl.name', 'cl.name AS categoria', DB::raw('SUM(sa.quantity) AS stock')
                                ,DB::raw('(SELECT count(hg_category_product.id_product) FROM hg_category_product WHERE hg_category_product.id_product = cp.id_product) AS n_cat'))
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('cp.id_product AND pl.id_lang = 1'))
                        ->join('hg_product AS p','p.id_product','=','cp.id_product')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cp.id_category AND cl.id_lang = 1'))
                        ->join('hg_stock_available AS sa','sa.id_product','=','cp.id_product')
                        ->where('cp.id_category','=',DB::raw('278 AND p.active = 1 AND (SELECT count(hg_category_product.id_product) FROM hg_category_product WHERE hg_category_product.id_product = cp.id_product) < 2'))
                        ->groupBy('p.id_product')
                        ->get();

            return response()->json($resultado);
        }

        function countProductosEnCategoriaOulet(){

            $resultado = DB::table('hg_category_product AS cp')
                        ->select('cp.id_product','pl.name', 'cl.name AS categoria', DB::raw('SUM(sa.quantity) AS stock')
                                ,DB::raw('(SELECT count(hg_category_product.id_product) FROM hg_category_product WHERE hg_category_product.id_product = cp.id_product) AS n_cat'))
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('cp.id_product AND pl.id_lang = 1'))
                        ->join('hg_product AS p','p.id_product','=','cp.id_product')
                        ->join('hg_category_lang AS cl','cl.id_category','=',DB::raw('cp.id_category AND cl.id_lang = 1'))
                        ->join('hg_stock_available AS sa','sa.id_product','=','cp.id_product')
                        ->where('cp.id_category','=',DB::raw('278 AND p.active = 1 AND (SELECT count(hg_category_product.id_product) FROM hg_category_product WHERE hg_category_product.id_product = cp.id_product) < 2'))
                        ->groupBy('p.id_product')
                        ->get();

            return response()->json(count($resultado));
        }

        //Productos SIN categoria predeterminada
        function productosSinCategoriaPredeterminada(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product','p.id_category_default','p.active','pl.name')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->where('p.active','=',DB::raw("1 AND (p.id_category_default = 2 OR p.id_category_default = '' OR ISNULL(p.id_category_default))"))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function countProductosSinCategoriaPredeterminada(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product','p.id_category_default','p.active','pl.name')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->where('p.active','=',DB::raw("1 AND (p.id_category_default = 2 OR p.id_category_default = '' OR ISNULL(p.id_category_default))"))
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json(count($resultado));
        }

        //Productos Sin MP_NombreArticulo
        function productosSinMPNombreArticulo(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product','pl.name AS nombreProducto','sa.quantity AS stock')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_stock_available AS sa','sa.id_product','=','p.id_product')
                        ->where('p.active','=',DB::raw('1 AND (SELECT COUNT(fp.id_product) FROM hg_feature_product AS fp WHERE fp.id_feature = 961
                                    AND fp.id_product = p.id_product ) = 0'))
                        ->groupBy('p.id_product')
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json($resultado);
        }

        function countProductosSinMPNombreArticulo(){

            $resultado = DB::table('hg_product AS p')
                        ->select('p.id_product','pl.name AS nombreProducto','sa.quantity AS stock')
                        ->join('hg_product_lang AS pl','pl.id_product','=',DB::raw('p.id_product AND pl.id_lang = 1'))
                        ->join('hg_stock_available AS sa','sa.id_product','=','p.id_product')
                        ->where('p.active','=',DB::raw('1 AND (SELECT COUNT(fp.id_product) FROM hg_feature_product AS fp WHERE fp.id_feature = 961
                                    AND fp.id_product = p.id_product ) = 0'))
                        ->groupBy('p.id_product')
                        ->orderBy('p.id_product','DESC')
                        ->get();

            return response()->json(count($resultado));
        }

    }

?>
