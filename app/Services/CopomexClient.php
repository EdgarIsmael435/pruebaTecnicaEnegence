<?php
namespace App\Services;

use GuzzleHttp\Client;

class CopomexClient
{
    protected $http;
    protected $token;

    public function __construct()
    {
        $this->http  = new Client(['base_uri' => 'https://api.copomex.com/query/','timeout'=>10]);
        $this->token = env('COPOMEX_TOKEN', 'pruebas');
    }

    // Metodo oficial para listar estados (según doc de COPOMEX):
    public function getEstados()
    {
        $res = $this->http->get("get_estados", ['query'=>['token'=>$this->token]]);
        return json_decode($res->getBody()->getContents(), true);
    }

    // Metodo oficial para listar municipios (según doc de COPOMEX):
    public function getMunicipiosPorEstado(string $estadoNombre)
    {
        $res = $this->http->get("get_municipio_por_estado/{$estadoNombre}", ['query'=>['token'=>$this->token]]);
        return json_decode($res->getBody()->getContents(), true);
    }
}
