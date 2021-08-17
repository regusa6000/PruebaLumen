<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller{

        public function index($id){

            // $producto = DB::table('hg_image_shop')->where('id_product',$id)->get();
            // $producto = DB::select('SELECT a.id_product,b.id_product_attribute,c.id_image FROM hg_product AS a
            //                         INNER JOIN hg_product_attribute AS b ON b.id_product = a.id_product
            //                         INNER JOIN hg_image_shop AS c ON c.id_product = a.id_product')
            //                         ->where('a.id_product = ?',$id)->get();
            //                         // WHERE a.id_product = ?',$id);

            $producto = DB::table('hg_product')
                                    ->join('hg_product_attribute','hg_product.id_product', '=','hg_product_attribute.id_product')
                                    ->join('hg_image_shop' , 'hg_product.id_product', '=' ,'hg_image_shop.id_product')
                                    ->select('hg_product.id_product','hg_product_attribute.id_product_attribute','hg_image_shop.id_image')
                                    ->where('hg_product.id_product','=',$id)
                                    ->get();

            return response()->json($producto);

        }

    }

?>
