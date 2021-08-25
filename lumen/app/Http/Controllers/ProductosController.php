<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller{

        public function index($id){

            $producto = DB::table('hg_image')
                                ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                                ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                                ->select('hg_product.id_product','hg_product_lang.name')
                                ->where('hg_product_lang.id_lang','=',1)
                                ->where('hg_product.id_product','=',$id)
                                ->get();

            $jsonResult = array();

            $jsonResult[0]['id_product'] = $producto[0]->id_product;
            $jsonResult[0]['name'] = $producto[0]->name;

            for ($a = 0 ; $a < 1 ; $a++){
                $jsonResult[$a]['attributes'] = DB::table('hg_image')
                                                ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                                                ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                                ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                                                ->select('hg_product_attribute_image.id_product_attribute','hg_image.id_image','hg_product.reference')
                                                ->where('hg_product_lang.id_lang','=',1)
                                                ->where('hg_product.id_product','=',$id)
                                                ->get();
            }
            return response()->json($jsonResult);
        }

        public function principal(){

            /*$producto = DB::table('hg_product')
                                        ->leftJoin('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                        ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                                        ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                                        ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                                        ->select('hg_product.id_product','hg_product_lang.meta_description','hg_product_attribute.id_product_attribute','hg_image_shop.id_image','hg_product_attribute.reference','hg_product.reference as reference1')
                                        ->where('hg_product_lang.id_lang','=',1)
                                        ->where('hg_product.active','=',1)
                                        ->orderBy('hg_image_shop.id_image','ASC')
                                        // ->groupBy(['hg_product.id_product','hg_product_attribute_combination.id_attribute','hg_image_shop.id_image','hg_product_attribute.reference'])
                                        ->get();


            // $jsonResult = array();
            // for ($a=0; $a < count($producto); $a++) {
            //     $jsonResult[$a]['id_product'] = $producto[$a]->id_product;
            //     $jsonResult[$a]['meta_description'] = $producto[$a]->meta_description;
            //     $jsonResult[$a]['id_product_attribute'] = $producto[$a]->id_product_attribute;
            //     $jsonResult[$a]['imagen'] = DB::table('hg_product')
            //                                 ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
            //                                 ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
            //                                 ->select('hg_image_shop.id_image','hg_product_attribute.reference','hg_product.reference as reference1')
            //                                 ->where('hg_product.active','=',1)
            //                                 ->orderBy('hg_image_shop.id_image','ASC')
            //                                 ->get();
            // }

            return response()->json($producto);
            // return response()->json($jsonResult);*/

            $producto = DB::table('hg_image')
                        ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                        ->select('hg_product.id_product','hg_product_lang.name','hg_product.reference','hg_product_attribute_image.id_product_attribute', 'hg_image.id_image', 'hg_product.reference')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->get();

            return response()->json($producto);
        }
    }

?>
