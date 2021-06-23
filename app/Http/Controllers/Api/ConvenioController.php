<?php

namespace App\Http\Controllers\Api;

use App\Entities\Convenios;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ConvenioController extends Controller
{

    /**
     * @OA\Get(
     *     path="/convenios",
     *     description="Retorna um objeto JSON com todos os convênios.",
     *     @OA\Response(
     *         response=200,
     *         description="OK.",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Houve algo de errado na requisição.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno da aplicação.",
     *     )
     * )
     */
    public function exportarConvenios(): JsonResponse
    {
        try {
            return response()->json((new Convenios())->todos());
        } catch (\Throwable $th) {
            return response()->json([
                'erro' => $th->getMessage()
            ], 400);
        }
    }
}
