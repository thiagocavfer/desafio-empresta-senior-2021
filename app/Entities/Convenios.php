<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class Convenios
{
    protected $data;

    public function __construct()
    {
        $arquivoConvenios = storage_path() . '/json/convenios.json';

        $arrConvenios = json_decode(
            file_get_contents($arquivoConvenios),
            true
        );

        $this->data = $arrConvenios;
    }

    /**
     * Retorno de todas os convênios.
     *
     * @return Collection
     **/
    public function todos(): array
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
        return Collection::make($this->todos())
            ->filter(function ($value, $key) use ($string) {
                return strtolower($key) === strtolower($string) || strtolower($value) === strtolower($string);
            });
    }
    */
}
