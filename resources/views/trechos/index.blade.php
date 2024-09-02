<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://bootswatch.com/5/sandstone/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Trechos</title>
    <style>
        .hidden{
            display: none;
        }
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
        .btn-icon {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1;
            border-radius: 0.2rem;
        }
    </style>
</head>
<body>
<nav-bar></nav-bar> 
    <div class="container">
        <h1 class="my-4">Lista de Trechos</h1>
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
                            <a href="{{ route('trechos.edit', $trecho) }}" class="btn btn-secondary btn-sm btn-icon">
                                <i class="fas fa-edit" title="Editar"></i>
                            </a>
                            <form class="delete-form" title="Delete" action="{{ route('trechos.destroy', $trecho->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                    <i class="fas fa-trash"></i>
                                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Você tem certeza?',
                    text: 'Isso não pode ser desfeito!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                        Swal.fire(
                            'Excluído!',
                            'O trecho foi excluído com sucesso.',
                            'success'
                        );
                    }
                });
            });
        });
    </script>
</body>
</html>
