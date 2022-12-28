<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;





class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ]);

            if ($validator->fails()) {
                // Mostrar mensaje de error y lista de errores
                return response()->json([
                    'message' => 'El email ya está registrado',
                    'errors' => $validator->errors()
                ], 422);
            }



            // Si no hay errores de validación, crea el nuevo usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // Devuelve una respuesta al cliente indicando que el usuario se ha creado correctamente
            return response($user, Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            // Si hay errores de validación, devuelve una respuesta con el código de estado HTTP 422 (Unprocessable Entity)
            // y el mensaje de error correspondiente
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        /*  return response()->json([
            'message' => 'Metodo Login OK'
        ]); */

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token');
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token" => $token, "user" => $user], Response::HTTP_OK)->withCookie($cookie);
        } else {
            return response(["message" => "Credenciales inválidas"], Response::HTTP_UNAUTHORIZED);
        }
    }
    public function userProfile(Request $request)
    {

        return response()->json([
            "message" => "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }
    public function logout()
    {

        $cookie = Cookie::forget('cookie_token');
        return response(["message" => "Cierre de sesión OK"], Response::HTTP_OK)->withCookie($cookie);
    }
    public function allUSers()
    {

        $users = User::all();
        return $users;
        /*  return response()->json([
            "users" => $users
        ]); */
    }

    public function upd(Request $request, $id)
    {

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function del($id)
    {

        $user = User::destroy($id);
        return $user;
    }
}
