<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
    use Illuminate\Auth\Access\Response;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

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
                                                ->select('hg_product_attribute_image.id_product_attribute','hg_image.id_image','hg_product.reference')
                                                ->where('hg_product_lang.id_lang','=',1)
                                                ->where('hg_product.id_product','=',$id)
                                                ->where('hg_product.active','=',1)
                                                //->orderBy('hg_image.position','ASC')
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
                        ->get();

                for($a = 0 ; $a < count($producto); $a++){
                    if($producto[$a]->id_product_attribute != null){

                        $producto[$a]['ax_id_combinado'] = DB::table('hg_ewax_product_attribute')
                                                            ->select('hg_ewax_product_attribute.ax_id')
                                                            ->where('hg_ewax_product_attribute.id_product_attribute','=',$producto[$a]->id_product_attribute)
                                                            ->get();

                    }
                    return response()->json($producto);
                }


        }

        public function tablaError(){

            $producto = DB::table('ng_errors')
                        ->join('hg_product','ng_errors.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->select('ng_errors.id_product','hg_product_lang.name','hg_product.reference', 'ng_errors.id_image', 'hg_product.reference')
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
                        ->select('ng_errors.id_product','hg_product_lang.name','hg_product.reference', 'ng_errors.id_image', 'hg_product.reference')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_product.active','=',1)
                        ->where('ng_errors.ok','=',1)
                        ->get();

            return response()->json($producto);
        }
    }

?>
