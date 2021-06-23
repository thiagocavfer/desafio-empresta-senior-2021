<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class Taxas
{
    protected $data;

    public function __construct()
    {
        $arquivoTaxas = storage_path() . '/json/taxas_instituicoes.json';

        $arrTaxas = json_decode(
            file_get_contents($arquivoTaxas),
            true
        );

        $this->data = $arrTaxas;
    }


    /**
     * Números de vezes possíveis para parcelamento.
     *
     * @return Array
     **/
    public function parcelamentosPossiveis()
    {
        return array_values(Collection::make($this->data)->sortBy([
            ['parcelas', 'asc'],
        ])->map(function ($data) {
            return $data;
        })->pluck('parcelas')
        ->unique()
        ->toArray());
    }


    /**
     * Retorno de todos os registros de Taxas/Instituições/Convênios/Parcelas.
     *
     * @return Collection
     **/
    public function todosDados(): Collection
    {
        return Collection::make($this->data)->sortBy([
            ['instituicao', 'asc'],
            ['convenio', 'asc'],
            ['parcelas', 'asc'],
        ])->map(function ($data) {
            return (object) $data;
        });
    }


    /**
     * Realização de filtro dentre as opções de empréstimos disponíveis
     * mediante as escolhas do cliente.
     *
     * @param Array $instituicoes Instituições escolhidas.
     * @param Array $convenios Convenios escolhidos.
     * @param Array $parcelas Opções de parcelamento selecionados.
     * @return Array
     **/
    public function filtrarOpcoes(
        array $instituicoes = [],
        array $convenios = [],
        array $parcelas = []
    ) {
        $cenariosSelecionados = [];

        foreach ($this->todosDados() as $cenario) {
            if (
                !empty($instituicoes) &&
                !in_array($cenario->instituicao, $instituicoes)
            ) {
                continue;
            }

            if (
                !empty($convenios) &&
                !in_array($cenario->convenio, $convenios)
            ) {
                continue;
            }

            if (
                !empty($parcelas) &&
                !in_array($cenario->parcelas, $parcelas)
            ) {
                continue;
            }

            $cenariosSelecionados[] = $cenario;
        }

        return $cenariosSelecionados;
    }


    /**
     * Cálculo do valor da parcela mediante um cenário
     * e valor pretendido pelo cliente.
     *
     * @param Float $valor Valor total desejado pelo cliente.
     * @param Object $convenio Objeto com os dados do cenário.
     * @return Object
     **/
    protected function calcularCenario(float $valor, object $cenario)
    {
        $valorParcela = round($valor * $cenario->coeficiente, 2);

        return (object) [
            'taxa' => $cenario->taxaJuros,
            'parcelas' => $cenario->parcelas,
            'valor_parcela' => $valorParcela,
            'convenio' => $cenario->convenio,
        ];
    }


    /**
     * Agrupando os cenários pela Instituição Financeira.
     *
     * @param Float $valor Valor total desejado pelo cliente.
     * @param Object $conveniosSelecionados Cenários disponíveis após realização do filtro.
     * @return Object
     **/
    protected function agruparPorInstituicao(float $valor, array $cenariosSelecionados)
    {
        if (empty($cenariosSelecionados)) {
            return [];
        }

        $arrRetorno = [];
        $instituicao = $cenariosSelecionados[0]->instituicao;

        foreach ($cenariosSelecionados as $cenario) {
            if ($instituicao != $cenario->instituicao) {
                $instituicao = $cenario->instituicao;
            }

            $arrRetorno[$instituicao][] = $this->calcularCenario(
                $valor,
                $cenario
            );
        }

        return $arrRetorno;
    }


    /**
     * Realização de filtro dentre as opções de empréstimos disponíveis
     * mediante as escolhas do cliente.
     * @param Float $valor Valor total desejado pelo cliente.
     * @param Array $instituicoes Instituições escolhidas.
     * @param Array $convenios Convenios escolhidos.
     * @param Array $parcelas Opções de parcelamento selecionados.
     * @return Array
     **/
    public function simularCenarios(
        float $valor,
        array $instituicoes = [],
        array $convenios = [],
        array $parcelas = []
    ) {
        return $this->agruparPorInstituicao(
            $valor,
            $this->filtrarOpcoes(
                $instituicoes,
                $convenios,
                $parcelas
            )
        );
    }
}
