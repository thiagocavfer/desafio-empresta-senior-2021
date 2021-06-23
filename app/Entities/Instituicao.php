<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class Instituicao
{
    protected $data;

    public function __construct()
    {
        $arquivoInstituicoes = storage_path() . '/json/instituicoes.json';

        $arrInstituicoes = json_decode(
            file_get_contents($arquivoInstituicoes),
            true
        );

        $this->data = $arrInstituicoes;
    }

    /**
     * Retorno de todas as instituições.
     *
     * @return Collection
     **/
    public function todas(): array
    {
        return Collection::make($this->data)
            ->reduce(function ($all, $instituicao) {
                return array_merge(
                    $all,
                    [$instituicao['chave'] => $instituicao['valor']]
                );
            }, []);
    }

    /*
    public function searchData($string): Collection
    {
        return Collection::make($this->todas())
            ->filter(function ($value, $key) use ($string) {
                return strtolower($key) === strtolower($string) || strtolower($value) === strtolower($string);
            });
    }
    */
}
