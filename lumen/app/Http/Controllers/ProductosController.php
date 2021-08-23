<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller{

        public function index($id){


            // $producto = DB::table('hg_product')
            //                         ->join('hg_product_attribute','hg_product.id_product', '=','hg_product_attribute.id_product')
            //                         ->join('hg_image_shop' , 'hg_product.id_product', '=' ,'hg_image_shop.id_product')
            //                         ->select('hg_product.id_product','hg_product_attribute.id_product_attribute','hg_image_shop.id_image')
            //                         ->where('hg_product.id_product','=',$id)
            //                         ->get();


            //     $producto = DB::table('hg_product')
            //                             ->leftJoin('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
            //                             ->leftJoin('hg_product_attribute','hg_product.id_product','=','hg_product_attribute.id_product')
            //                             ->leftJoin('hg_product_attribute_combination','hg_product_attribute.id_product_attribute','=','hg_product_attribute_combination.id_product_attribute')
            //                             ->leftJoin('hg_image_shop','hg_product.id_product','=','hg_image_shop.id_product')
            //                             ->select('hg_product.id_product,hg_product_attribute.id_product_attribute,hg_image_shop.id_image,hg_product_attribute.reference')
            //                             ->where('hg_product_lang.id_lang','=',1)
            //                             ->where('hg_product.active','=',1)
            //                             ->where('hg_product.id_product','=',$id)
            //                             ->groupBy(['hg_product.id_product','hg_product_attribute_combination.id_attribute','hg_image_shop.id_image','hg_product_attribute.reference'])
            //                             ->get();

                $producto = DB::table('hg_product')
                                        ->leftJoin('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                        ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                                        ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                                        ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                                        ->select('hg_product.id_product','hg_product_attribute.id_product_attribute','hg_image_shop.id_image','hg_product_attribute.reference','hg_product.reference as reference1')
                                        ->where('hg_product_lang.id_lang','=',1)
                                        ->where('hg_product.active','=',1)
                                        ->where('hg_product.id_product','=',$id)
                                        // ->groupBy(['hg_product.id_product','hg_product_attribute_combination.id_attribute','hg_image_shop.id_image','hg_product_attribute.reference'])
                                        ->get();

            return response()->json($producto);

        }

        public function principal(){

            $producto = DB::table('hg_product')
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

            return response()->json($producto);

        }

    }

?>
