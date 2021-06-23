<?php

namespace App\Http\Controllers\Api;

use App\Entities\Instituicao;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class InstituicaoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/instituicoes",
     *     description="Retorna um objeto JSON com todos as instituições.",
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
    public function exportarInstituicoes(): JsonResponse
    {
        try {
            return response()->json((new Instituicao())->todas());
        } catch (\Throwable $th) {
            return response()->json([
                'erro' => $th->getMessage()
            ], 400);
        }
    }
}
