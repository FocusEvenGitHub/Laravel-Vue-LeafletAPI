{{-- resources/views/trechos/edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trecho</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/sandstone/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .form-label {
            margin-top: 10px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn-primary {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Editar Trecho</h1>
        <form action="{{ route('trechos.update', $trecho->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="date" class="form-label">Data de Referência:</label>
                <input type="date" name="data_referencia" id="date" class="form-control" value="{{ old('data_referencia', $trecho->data_referencia) }}">
            </div>

            <div class="mb-3">
                <label for="uf" class="form-label">Unidade da Federação:</label>
                <select name="uf_id" id="uf" class="form-select">
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->id }}" {{ $uf->id == $trecho->uf_id ? 'selected' : '' }}>
                            {{ $uf->uf }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rodovia" class="form-label">Rodovia:</label>
                <select name="rodovia_id" id="rodovia" class="form-select">
                    @foreach ($rodovias as $rodovia)
                        <option value="{{ $rodovia->id }}" {{ $rodovia->id == $trecho->rodovia_id ? 'selected' : '' }}>
                            {{ $rodovia->rodovia }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="km-inicial" class="form-label">Quilometragem Inicial:</label>
                <input type="number" name="quilometragem_inicial" id="km-inicial" class="form-control" value="{{ old('quilometragem_inicial', $trecho->quilometragem_inicial) }}">
            </div>

            <div class="mb-3">
                <label for="km-final" class="form-label">Quilometragem Final:</label>
                <input type="number" name="quilometragem_final" id="km-final" class="form-control" value="{{ old('quilometragem_final', $trecho->quilometragem_final) }}">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</body>
</html>
