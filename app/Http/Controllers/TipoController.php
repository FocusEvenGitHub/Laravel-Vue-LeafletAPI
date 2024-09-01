<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TipoController extends Controller
{
    public function fetchTipos(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'uf' => 'required|string|size:2', // Ex.: 'AL', 'SP'
            'br' => 'required|string',        // Número da rodovia, ex.: '101'
            'data_referencia' => 'required|date',
        ]);

        try {
            // Parâmetros da requisição
            $uf = strtoupper($request->uf);
            $br = $request->br;
            $data_referencia = $request->data_referencia;

            // URL da API do DNIT
            $url = "https://servicos.dnit.gov.br/sgplan/apigeo/snv/listartipoporbruf";
            $params = [
                'data' => $data_referencia,
                'uf' => $uf,
                'br' => $br
            ];

            // Realiza a requisição GET para a API externa
            $response = Http::withOptions(['verify' => false])
                            ->get($url, $params);

            // Verifica se a resposta foi bem-sucedida
            if ($response->successful()) {
                $tipos = $response->json();
                return response()->json(['success' => true, 'tipos' => $tipos]);
            } else {
                Log::error('Erro ao buscar tipos do DNIT: ' . $response->body());
                return response()->json(['success' => false, 'message' => 'Erro ao buscar tipos de rodovias'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao processar a solicitação: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao buscar tipos de rodovias'], 500);
        }
    }
}
