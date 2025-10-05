<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Municipio;
use App\Services\CopomexClient;
use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    // Listado principal
    public function index()
    {
        $estados = Estado::orderBy('nombre_estado')->get();

        return view('estados.index', compact('estados'));
    }

    // Sincroniza/Importa estados (idempotente)
    public function sync(CopomexClient $copo)
    {
        $data = $copo->getEstados();
        $lista = $data['response']['estado'] ?? [];

        if (empty($lista)) {
            return back()->with('error', 'No se pudieron obtener los estados desde la API.');
        }

        // Guardar de forma idempotente
        DB::transaction(function () use ($lista) {
            foreach ($lista as $nombre) {
                if (is_string($nombre) && $nombre !== '') {
                    Estado::firstOrCreate(['nombre_estado' => trim($nombre)]);
                }
            }
        });

        return redirect()
            ->route('estados.index')
            ->with('ok', 'Estados sincronizados correctamente.');
    }

    // Municipios por Estado (AJAX)
    public function municipios($estadoId, CopomexClient $copo)
    {
        $estado = Estado::findOrFail($estadoId);

        // 1️ Consultar COPOMEX con el nombre del estado
        $data = $copo->getMunicipiosPorEstado($estado->nombre_estado);

        // 2️ Extraer lista de municipios reales
        $lista = $data['response']['municipios'] ?? [];

        if (empty($lista)) {
            return response()->json([
                'estado' => $estado->nombre_estado,
                'municipios' => [],
                'error' => 'No se pudieron obtener municipios del servicio COPOMEX.',
            ], 500);
        }

        // 3️ Guardar idempotente
        DB::transaction(function () use ($estado, $lista) {
            foreach ($lista as $nombre) {
                if (is_string($nombre) && $nombre !== '') {
                    Municipio::firstOrCreate([
                        'id_estado' => $estado->id_estado,
                        'nombre_municipio' => trim($nombre),
                    ]);
                }
            }
        });

        // 4️ Devolver JSON limpio al front
        $municipios = $estado->municipios()->orderBy('nombre_municipio')->pluck('nombre_municipio');

        return response()->json([
            'estado' => $estado->nombre_estado,
            'municipios' => $municipios,
        ]);
    }
}
