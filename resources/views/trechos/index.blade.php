<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://bootswatch.com/5/sandstone/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Trechos</title>
    <style>
        .container {
            margin-top: 20px;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination .page-item .page-link {
            color: #333;
        }
        table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Tabela de Trechos</h1>
        <a href="{{ route('trechos.create') }}" class="btn btn-primary mb-3">Cadastrar Novo Trecho</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>UF</th>
                    <th>Rodovia</th>
                    <th>Quilometragem Inicial</th>
                    <th>Quilometragem Final</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trechos as $trecho)
                    <tr>
                        <td>{{ $trecho->uf->uf }}</td>
                        <td>{{ $trecho->rodovia->rodovia }}</td>
                        <td>{{ $trecho->quilometragem_inicial }}</td>
                        <td>{{ $trecho->quilometragem_final }}</td>
                        <td>
                            <a href="{{ route('trechos.edit', $trecho) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="{{ route('trechos.destroy', $trecho->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $trechos->links() }}
        </div>
    </div>
</body>
</html>
