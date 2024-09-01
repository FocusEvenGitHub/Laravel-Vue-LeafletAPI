<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Trecho</title>
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
        <h1 class="my-4">Cadastrar Novo Trecho</h1>
        <form action="{{ route('trechos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Data de Referência:</label>
                <input type="date" name="data_referencia" id="date" class="form-control" value="{{ old('data_referencia') }}">
            </div>

            <div class="mb-3">
                <label for="uf" class="form-label">Unidade da Federação:</label>
                <select name="uf_id" id="uf" class="form-select">
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->id }}">{{ $uf->uf }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rodovia" class="form-label">Rodovia:</label>
                <select name="rodovia_id" id="rodovia" class="form-select">
                    @foreach ($rodovias as $rodovia)
                        <option value="{{ $rodovia->id }}">{{ $rodovia->rodovia }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="km-inicial" class="form-label">Quilometragem Inicial:</label>
                <input type="number" name="quilometragem_inicial" id="km-inicial" class="form-control" value="{{ old('quilometragem_inicial') }}">
            </div>

            <div class="mb-3">
                <label for="km-final" class="form-label">Quilometragem Final:</label>
                <input type="number" name="quilometragem_final" id="km-final" class="form-control" value="{{ old('quilometragem_final') }}">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
