<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
        /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Obtener mi token de autenticación",
     *     tags={"login"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *        required={"email","password"},
     *        @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *        @OA\Property(property="password", type="string", example="password")
     *      )
     *   ),
     *     @OA\Response(response=200, description="Operación exitosa"),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     * )
     */

     public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!Auth::attempt($data)){
            return response()->json(['message' => 'Acceso no autorizado'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('api-token',['manage-products'])->plainTextToken;
        return response()->json(['token' => $token], 200);
    }
}
