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
use Illuminate\Validation\ValidationException;






class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Crea la regla de contraseña segura
            Validator::extend('strong_password', function($attribute, $value, $parameters, $validator) {
                return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $value);
            });

            // Reemplaza el mensaje de error de la regla de contraseña segura
            Validator::replacer('strong_password', function($message, $attribute, $rule, $parameters) {
                return "La contraseña debe contener al menos una letra minúscula, al menos una letra mayúscula, al menos un número y una longitud mínima de 8 caracteres.";
            });

            // Valida los datos de entrada
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8|strong_password'
            ]);

            if ($validator->fails()) {
                // Muestra el mensaje de error personalizado
                return response()->json([
                    'message' => $validator->errors()->first('password'),
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
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ], [
                'email.required' => 'Debe ingresar un correo',
                'password.required' => 'Debe ingresar su contraseña'
            ]);
        } catch (ValidationException $e) {
            return response(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["message" => "Inicio de sesión correcto", "token" => $token, "user" => $user], Response::HTTP_OK)->withCookie($cookie);
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
        try {
            $user = User::destroy($id);
            return response()->json([
                "message" => "El usuario ha sido eliminado con éxito"
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ha ocurrido un error al eliminar el usuario"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
