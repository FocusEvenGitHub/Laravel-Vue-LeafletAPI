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
    <div id="app" class="container">
        <h1 class="my-4">Cadastrar Novo Trecho</h1>
        <form @submit.prevent="handleSubmit">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Data de Referência:</label>
                <input type="date" name="data_referencia" id="date" class="form-control" v-model="formData.data_referencia">
            </div>

            <div class="mb-3">
                <label for="uf" class="form-label">Unidade da Federação:</label>
                <select name="uf_id" id="uf" class="form-select" v-model="formData.uf_id" @change="fetchRodovias(formData.uf_id)">
                    <option value="">Selecione uma UF</option>
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->id }}">{{ $uf->uf }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rodovia" class="form-label">Rodovia:</label>
                <select class="form-select" name="rodovia_id" id="rodovia" v-model="formData.rodovia_id" :disabled="!formData.uf_id">
                    <option value="">Selecione uma rodovia</option>
                    <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia.id">@{{ rodovia.rodovia }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="km-inicial" class="form-label">Quilometragem Inicial:</label>
                <input type="number" name="quilometragem_inicial" id="km-inicial" class="form-control" v-model="formData.quilometragem_inicial">
            </div>

            <div class="mb-3">
                <label for="km-final" class="form-label">Quilometragem Final:</label>
                <input type="number" name="quilometragem_final" id="km-final" class="form-control" v-model="formData.quilometragem_final">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <!-- Inclua Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <!-- Inclua Axios para requisições AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
    new Vue({
        el: '#app',
        data() {
            return {
                formData: {
                    data_referencia: '',
                    uf_id: '',
                    rodovia_id: '',
                    quilometragem_inicial: '',
                    quilometragem_final: ''
                },
                rodovias: []
            }
        },
        methods: {
            fetchRodovias(ufId) {
                if (!ufId) {
                    this.rodovias = [];
                    return;
                }

                axios.get('/api/rodovias', {
                    params: { uf_id: ufId }
                })
                .then(response => {
                    this.rodovias = response.data.map(rodovia => ({
                        rodovia: rodovia.rodovia,
                        id: rodovia.id
                    }));
                })
                .catch(error => {
                    console.error('Erro ao carregar rodovias:', error);
                });
            },
            handleSubmit() {
                axios.post('{{ route('trechos.store') }}', this.formData)
                    .then(response => {
                        console.log('Trecho cadastrado com sucesso:', response);
                        // Redirecionar ou exibir mensagem de sucesso conforme necessário
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 422) {
                            console.error('Erros de validação:', error.response.data.errors);
                            // Aqui você pode exibir os erros de validação na interface do usuário
                        } else {
                            console.error('Erro ao cadastrar trecho:', error);
                        }
                    });
            }
        }
    });
</script>

</body>
</html>
