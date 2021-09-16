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
                return response()->json(['message'=> 'Estos campos son obligatorios']);
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
                    return response()->json(['message'=> 'Contraseña Incorrecta']);
                }else{
                    $datosUser = DB::table('ng_users')
                                ->select('*')
                                ->where('email','=',$email)
                                ->get();
                    return response()->json(['message'=> 'OK','data'=>$datosUser]);
                }

            }

        }

        public function register(Request $request){

            $name= $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            if($password == null || $password == null){
                return response()->json(['message'=> 'Estos campos son obligatorios']);
            }else{
                    $emailVerify = DB::table('ng_users')
                                            ->select('email')
                                            ->where('email','=',$email)
                                            ->pluck('email')
                                            ->first();

                    if($email == $emailVerify){
                        return response()->json(['message'=> 'El email ya esta registrado']);
                    }else{

                        /*Encriptamos la contraseña para luego insertarla en la bbdd*/
                        $password_crypt = Hash::make($password);

                        $consulta = DB::table('ng_users')->insert([
                            'name'=>$name,
                            'email'=> $email,
                            'password'=> $password_crypt
                        ]);

                        $datosUser = DB::table('ng_users')
                            ->select('*')
                            ->where('email','=',$email)
                            ->get();
                        return response()->json(['message'=> 'OK','data'=>$datosUser]);
                    }

            }

        }

    }

?>
