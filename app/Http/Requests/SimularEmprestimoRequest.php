<?php

namespace App\Http\Requests;

use App\Entities\Convenios;
use App\Entities\Instituicao;
use App\Entities\Taxas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimularEmprestimoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'valor_emprestimo' => 'required|regex:/^\d*(\.\d{2})?$/',
            'instituicoes.*' => [
                'nullable',
                Rule::in(array_keys((new Instituicao())->todas())),
            ],
            'convenios.*' => [
                'nullable',
                Rule::in(array_keys((new Convenios())->todos())),
            ],
            'parcelas.*' => [
                'nullable',
                Rule::in(array_values((new Taxas())->parcelamentosPossiveis())),
            ]
        ];
    }
}
