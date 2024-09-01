<?php

use App\Models\Uf;
use App\Models\Rodovia;
use Illuminate\Http\Request;
use App\Http\Controllers\TrechoController;
use App\Http\Controllers\TipoController;


Route::get('/ufs', function () {
    return Uf::all();
});


Route::get('/rodovias', function (Request $request) {
    $ufId = $request->query('uf_id');
    if ($ufId) {
        return Rodovia::where('uf_id', $ufId)->get();
    }
    return null;
});


Route::post('/trechos', [TrechoController::class, 'store']);


Route::get('/tipos', [TipoController::class, 'fetchTipos']);