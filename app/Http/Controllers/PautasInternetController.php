<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PautasInternet;
use Illuminate\Support\Facades\Validator;


class PautasInternetController extends Controller
{


    public function index()
    {
        try {
            $pautas = PautasInternet::paginate(10);
            $pautas = PautasInternet::all();
            return response()->json(['pautas' => $pautas]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las pautas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pauta = PautasInternet::findOrFail($id);
            return $pauta;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se ha encontrado la pauta con el id especificado'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'fec_pauta'    => 'required|date',
                'des_titular'  => 'required|string',
                'des_resumen'  => 'required|string',
                'des_ruta_web' => 'required|string',
                'des_ruta_imagen' => 'required|string',
                'des_ruta_video' => 'required|string',
            ]);
            // Create a new PautaInternet instance
            $pauta = PautasInternet::create($validatedData);
            // Return a response indicating that the PautaInternet was created successfully
            return response()->json(['message' => 'PautaInternet creada correctamente.', 'pauta' => $pauta], 201);
        } catch (\Exception $e) {
            // If there are validation errors, return a response with the corresponding status code and error message
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function delete($id)
    {
        try {
            $pauta = PautasInternet::findOrFail($id);
            $pauta->delete();
            return response()->json(["message" => "Pauta eliminada exitosamente"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al eliminar la pauta"], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            // Buscar el registro de la pauta en la tabla "pautas_internet"
            $pauta = PautasInternet::findOrFail($id);

            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'fec_pauta' => 'required',
                'des_titular' => 'required',
                'des_resumen' => 'required',
                'des_ruta_web' => 'required',
                'des_ruta_imagen' => 'required',
                'des_ruta_video' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Hay errores de validación.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Actualizar los campos del registro con los datos de entrada
            $pauta->fec_pauta = $request->fec_pauta;
            $pauta->des_titular = $request->des_titular;
            $pauta->des_resumen = $request->des_resumen;
            $pauta->des_ruta_web = $request->des_ruta_web;
            $pauta->des_ruta_imagen = $request->des_ruta_imagen;
            $pauta->des_ruta_video = $request->des_ruta_video;

            // Guardar los cambios en la base de datos
            $pauta->save();

            // Devolver una respuesta al cliente indicando que la edición fue exitosa
            return response()->json([
                'message' => 'La pauta se ha editado correctamente.',
                'pauta' => $pauta
            ], 200);
        } catch (\Exception $e) {
            // Si ocurre un error, devolver una respuesta con el código de estado HTTP 500 (Internal Server Error)
            // y el mensaje de error correspondiente
            return response()->json(['message' => 'Ha ocurrido un error al editar la pauta'], 500);
        }
    }

    public function pagination($per_page)
    {
        try {
            $pautas = PautasInternet::paginate($per_page);
            return response()->json(['pautas' => $pautas]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las pautas: ' . $e->getMessage()
            ], 500);
        }
    }
}
