<?php

    namespace App\Http\Controllers;

    use App\Models\Productos;
    use Illuminate\Auth\Access\Response;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller{

        public function login(Request $request){

            $email = $request->input('email');
            $password = $request->input('password');

            if($email == null || $password == null){
                return 'Estos campos son obligatorios';
            }else{
                /*Ponemos first y pluck para asignarle que solo queremos el primer resultado y con el valor dado*/
                $password_hash = DB::table('ng_users')
                                ->select('password')
                                ->where('email','=',$email)
                                ->pluck('password')
                                ->first();

                //Esta función devolvera 1 si hubo comparación y todo fue correcto, y 0 si las contraseñas son diferentes, lo que es error
                $password_verify = Hash::check($password,$password_hash);

                if ($password_verify == null){
                    return 'No hubo comparación';
                }else{
                    return 'Hubo Comparación';
                }

            }

        }

        public function register(Request $request){

            $email = $request->input('email');
            $password = $request->input('password');

            if($password == null || $password == null){
                return 'Estos campos son obligatorios';
            }else{
                    $emailVerify = DB::table('ng_users')
                                            ->select('email')
                                            ->where('email','=',$email)
                                            ->pluck('email')
                                            ->first();

                    if($email == $emailVerify){
                        return 'El email ya esta registrado';
                    }else{

                        /*Encriptamos la contraseña para luego insertarla en la bbdd*/
                        $password_crypt = Hash::make($password);

                        $consulta = DB::table('ng_users')->insert([
                            'email'=> $email,
                            'password'=> $password_crypt
                        ]);

                        return $consulta;

                    }

            }

        }

    }

?>
