<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
use Illuminate\Auth\Access\Response;
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

                // $producto = DB::table('hg_product')
                //                         ->leftJoin('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                //                         ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                //                         ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                //                         ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                //                         ->select('hg_product.id_product','hg_product_attribute.id_product_attribute','hg_image_shop.id_image','hg_product_attribute.reference','hg_product.reference as reference1')
                //                         ->distinct('hg_product.id_product')
                //                         ->where('hg_product_lang.id_lang','=',1)
                //                         ->where('hg_product.active','=',1)
                //                         ->where('hg_product.id_product','=',$id)
                //                         // ->groupBy(['hg_product.id_product','hg_product_attribute_combination.id_attribute','hg_image_shop.id_image','hg_product_attribute.reference'])
                //                         ->get();

                $producto = DB::table('hg_product')
                                        ->leftJoin('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                                        ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                                        ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                                        ->select('hg_product.id_product','hg_image_shop.id_image','hg_product_attribute.id_product_attribute')
                                        ->where('hg_product_lang.id_lang','=',1)
                                        ->where('hg_product.id_product','=',$id)
                                        //->groupBy(['hg_product.id_product','hg_product_attribute_combination.id_attribute','hg_image_shop.id_image','hg_product_attribute.reference'])
                                        ->get();

            // return response()->json($producto);



            $jsonResult = array();
            /*Llenamos los campos recogidos, fuera del array para que no se repitan*/
            $jsonResult[0]['id_product'] = $producto[0]->id_product;
            $jsonResult[0]['id_image'] = $producto[0]->id_image;
            $jsonResult[0]['id_product_attribute'] = $producto[0]->id_product_attribute;

            for ($a=0; $a < 1; $a++) {

                if($producto[$a]->id_product_attribute != null){
                    //Cuando es nulo hacemos la consulta sobre la tabla "product_attribute"

                    $jsonResult[$a]['attributes'] = DB::table('hg_product')
                                    ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                                    ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                                    ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                                    ->select('hg_product_attribute.id_product_attribute','hg_product_attribute.reference','hg_product.reference as reference1','hg_image_shop.id_image')
                                    ->where('hg_product.active','=',1)
                                    ->where('hg_product.id_product','=',$id)
                                    ->orderBy('hg_product_attribute.id_product_attribute','ASC')
                                    ->get()
                                    ->groupBy('hg_product.id_product','hg_product_attribute_combination.id_product_attribute');

                    return response()->json($jsonResult);


                }else{
                    //Cuando no es nulo sobre la tabla "product_image"
                    // $jsonResult[$a]['id_product'] = $producto[$a]->id_product;
                    // $jsonResult[$a]['id_image'] = $producto[$a]->id_image;
                    // $jsonResult[$a]['id_product_attribute'] = $producto[$a]->id_product_attribute;
                    // $jsonResult[$a]['imagen'] = DB::table('hg_product')
                    //                         ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                    //                         ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                    //                         ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                    //                         ->select('hg_product_attribute.id_product_attribute','hg_product_attribute.reference','hg_product.reference as reference1','hg_image_shop.id_image')
                    //                         ->where('hg_product.active','=',1)
                    //                         ->where('hg_product.id_product','=',$id)
                    //                         ->orderBy('hg_product_attribute.id_product_attribute','ASC')
                    //                         ->get()
                    //                         ->groupBy('hg_product.id_product','hg_product_attribute_combination.id_product_attribute','hg_product_attribute.id_product');
                    $jsonResult[$a]['attributes'] = null;
                    return response()->json($jsonResult);
                }


                /* Parte Buena de la consulta */
                // $jsonResult[$a]['id_product'] = $producto[$a]->id_product;
                // $jsonResult[$a]['id_image'] = $producto[$a]->id_image;
                // $jsonResult[$a]['imagen'] = DB::table('hg_product')
                //                             ->leftJoin('hg_product_attribute','hg_product_attribute.id_product','=','hg_product.id_product')
                //                             ->leftJoin('hg_product_attribute_combination','hg_product_attribute_combination.id_product_attribute','=','hg_product_attribute.id_product_attribute')
                //                             ->leftJoin('hg_image_shop','hg_image_shop.id_product','=','hg_product.id_product')
                //                             ->select('hg_product_attribute.id_product_attribute','hg_product_attribute.reference','hg_product.reference as reference1','hg_image_shop.id_image')
                //                             ->where('hg_product.active','=',1)
                //                             ->where('hg_product.id_product','=',$id)
                //                             ->orderBy('hg_product_attribute.id_product_attribute','ASC')
                //                             ->get()
                //                             ->groupBy('hg_product.id_product','hg_product_attribute_combination.id_product_attribute','hg_image_shop.id_image');
            }

            // return response()->json($producto);
            // return response()->json($jsonResult);

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
            // return response()->json($jsonResult);

        }

    }

?>
