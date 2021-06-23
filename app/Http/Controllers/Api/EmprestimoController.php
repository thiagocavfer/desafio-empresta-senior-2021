<?php

namespace App\Http\Controllers\Api;

use App\Entities\Taxas;
use App\Http\Controllers\Controller;
use App\Http\Requests\SimularEmprestimoRequest;
use Illuminate\Http\JsonResponse;

class EmprestimoController extends Controller
{

    /**
     * @OA\Post(
     *     path="/credito/simular",
     *     description="Simulação de crédito para o cliente.",
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
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"valor_emprestimo"},
     *              @OA\Property(
     *                  property="valor_emprestimo",
     *                  type="float",
     *                  example="1500"
     *              ),
     *              @OA\Property(
     *                  property="instituicoes",
     *                  type="array",
     *                  @OA\Items(type="string",example="BMG"),
     *              ),
     *              @OA\Property(
     *                  property="convenios",
     *                  type="array",
     *                  @OA\Items(type="string",example="INSS"),
     *              ),
     *              @OA\Property(
     *                  property="parcelas",
     *                  type="array",
     *                  @OA\Items(type="integer",example="60"),
     *              ),
     *          ),
     *      ),
     * )
     */
    public function simular(SimularEmprestimoRequest $request): JsonResponse
    {
        try {
            return response()->json((new Taxas())->simularCenarios(
                $request->valor_emprestimo,
                $request->instituicoes ?? [],
                $request->convenios ?? [],
                $request->parcelas ?? [],
            ));
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'erro' => $th->getMessage()
            ], 400);
        }
    }
}
