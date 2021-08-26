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
                                                ->where('hg_product.active','=',1)
                                                ->orderBy('hg_image.position','ASC')
                                                ->get();
            }

            return response()->json($jsonResult);
        }

        public function principal(){

            $producto = DB::table('hg_image')
                        ->join('hg_product','hg_image.id_product','=','hg_product.id_product')
                        ->join('hg_product_lang','hg_product.id_product','=','hg_product_lang.id_product')
                        ->leftJoin('hg_product_attribute_image','hg_image.id_image','=','hg_product_attribute_image.id_image')
                        ->select('hg_product.id_product','hg_product_lang.name','hg_product.reference','hg_product_attribute_image.id_product_attribute', 'hg_image.id_image', 'hg_product.reference')
                        ->where('hg_product_lang.id_lang','=',1)
                        ->where('hg_product.active','=',1)
                        ->orderBy('hg_image.position','ASC')
                        ->get();

            return response()->json($producto);
        }
    }

?>
