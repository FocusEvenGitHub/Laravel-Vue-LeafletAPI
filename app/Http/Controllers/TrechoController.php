<?php
// app/Http/Controllers/TrechoController.php

namespace App\Http\Controllers;

use App\Models\Trecho;
use App\Models\Uf;
use App\Models\Rodovia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class TrechoController extends Controller
{
    // Exibir todos os trechos
    public function index()
    {
        $trechos = Trecho::with(['uf', 'rodovia'])->paginate(10);
        return view('trechos.index', compact('trechos'));
    }

    // Mostrar o formulário de criação
    public function create()
    {
        $ufs = Uf::all();
        return view('trechos.create', compact('ufs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|exists:ufs,id',
            'rodovia_id' => 'required|exists:rodovias,id',
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric',
            'tipo' => 'required|string', 
        ]);

        $uf = \App\Models\Uf::findOrFail($request->uf_id);
        $rodovia = \App\Models\Rodovia::findOrFail($request->rodovia_id);

        $url = "https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha?";
        $params = [
            'br' => $rodovia->rodovia,  // Número da rodovia
            'tipo' => $request->tipo,   // Tipo de trecho
            'uf' => $uf->uf,            // Código da UF
            'cd_tipo' => 'null',
            'data' => $request->data_referencia,
            'kmi' => $request->quilometragem_inicial,
            'kmf' => $request->quilometragem_final,
        ];
        
        $fullUrl = $url . http_build_query($params);

        // Fazer requisição GET
        try {
            $response = Http::withOptions([
                'verify' => false, 
            ])->get($fullUrl);

            if ($response->successful()) {
                $geoData = $response->json();

                $trecho = Trecho::create([
                    'data_referencia' => $request->data_referencia,
                    'uf_id' => $request->uf_id,
                    'rodovia_id' => $request->rodovia_id,
                    'quilometragem_inicial' => $request->quilometragem_inicial,
                    'quilometragem_final' => $request->quilometragem_final,
                    'geo' => json_encode($geoData) 
                ]);

                return response()->json([
                    'success' => true,
                    'trecho' => $trecho,
                    'geo' => json_encode($geoData) 
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao buscar geometria'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Mostrar o formulário de edição
    public function edit(Trecho $trecho, Request $request)
    {
        // Obter o uf_id da requisição, se fornecido
        $ufId = $trecho->uf_id;

        // Obter todas as UFs
        $ufs = Uf::all();

        // Filtrar as rodovias com base no uf_id, se fornecido
        $rodovias = Rodovia::when($ufId, function ($query) use ($ufId) {
            return $query->where('uf_id', $ufId);
        })->get();

        return view('trechos.edit', compact('trecho', 'ufs', 'rodovias'
        ));
    }




    // Atualizar um trecho
    public function update(Request $request, Trecho $trecho)
    {
        $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|exists:ufs,id',
            'rodovia_id' => 'required|exists:rodovias,id',
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric',
        ]);

        $trecho->update($request->all());

        return redirect()->route('trechos.index')->with('success', 'Trecho atualizado com sucesso!');
    }

    // Excluir um trecho
    public function destroy(Trecho $trecho)
    {
        $trecho->delete();
        return redirect()->route('trechos.index')->with('success', 'Trecho excluído com sucesso!');
    }
}
