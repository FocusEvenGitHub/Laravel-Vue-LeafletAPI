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
        <form @submit.prevent="saveTrecho">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Data de Referência:</label>
                <input type="date" name="data_referencia" id="date" class="form-control" v-model="filters.date" @change="fetchTipos">
            </div>

            <div class="mb-3">
                <label for="uf" class="form-label">Unidade da Federação:</label>
                <select name="uf_id" id="uf" class="form-select" v-model="filters.uf" @change="fetchRodovias">
                    <option value="">Selecione uma UF</option>
                    @foreach ($ufs as $uf)
                        <option :value="'{{ $uf->uf }}'">{{ $uf->uf }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rodovia" class="form-label">Rodovia:</label>
                <select class="form-select" name="rodovia_id" id="rodovia" v-model="filters.rodovia" @change="fetchTipos" :disabled="!filters.uf">
                    <option value="">Selecione uma rodovia</option>
                    <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia.rodovia">@{{ rodovia.rodovia }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Trecho:</label>
                <select class="form-select" name="tipo_trecho" id="tipo" v-model="filters.tipo" :disabled="!tipos.length">
                    <option value="">Selecione um tipo</option>
                    <option v-for="tipo in tipos" :key="tipo" :value="tipo">@{{ tipo }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="km-inicial" class="form-label">Quilometragem Inicial:</label>
                <input type="number" name="quilometragem_inicial" id="km-inicial" class="form-control" v-model="filters.kmInicial">
            </div>

            <div class="mb-3">
                <label for="km-final" class="form-label">Quilometragem Final:</label>
                <input type="number" name="quilometragem_final" id="km-final" class="form-control" v-model="filters.kmFinal">
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
                    filters: {
                        date: '',
                        uf: '',
                        rodovia: '',
                        tipo: '',
                        kmInicial: '',
                        kmFinal: ''
                    },
                    rodovias: [],
                    tipos: [],
                    geoData: {},
                    ufs: @json($ufs) // Carregue a lista de UFs diretamente do backend
                }
            },
            methods: {
                fetchRodovias() {
                    if (!this.filters.uf) {
                        this.rodovias = [];
                        return;
                    }

                    axios.get('/api/rodovias', {
                        params: { uf_id: this.ufs.find(uf => uf.uf === this.filters.uf)?.id }
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
                fetchTipos() {
                    const selectedUf = this.ufs.find(uf => uf.uf === this.filters.uf);
                    const selectedRodovia = this.rodovias.find(rodovia => rodovia.rodovia === this.filters.rodovia);

                    if (!selectedUf || !selectedRodovia) return;

                    axios.get('/api/tipos', {
                        params: {
                            uf: selectedUf.uf,
                            br: selectedRodovia.rodovia,
                            data_referencia: this.filters.date
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.tipos = response.data.tipos.lista_tp_trecho.split(',').map(tipo => tipo.trim());
                        } else {
                            console.error('Erro ao buscar tipos de rodovias:', response.data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar tipos de rodovias:', error);
                    });
                },
                async saveTrecho() {
                    try {
                        const ufId = this.ufs.find(uf => uf.uf === this.filters.uf)?.id;
                        const rodoviaId = this.rodovias.find(rodovia => rodovia.rodovia === this.filters.rodovia)?.id;

                        if (!ufId || !rodoviaId) {
                            alert('UF ou rodovia inválida.');
                            return;
                        }

                        const response = await axios.post('/api/trechos', {
                            data_referencia: this.filters.date,
                            uf_id: ufId,
                            rodovia_id: rodoviaId,
                            quilometragem_inicial: this.filters.kmInicial,
                            quilometragem_final: this.filters.kmFinal,
                            tipo: this.filters.tipo, 
                        });

                        if (response.data.success) {
                            alert('Trecho salvo com sucesso!');
                            this.geoData = response.data.geo; 

                            window.location.href = '/trechos';
                        } else {
                            alert('Erro ao salvar trecho.');
                        }
                    } catch (error) {
                        console.error('Erro ao salvar trecho:', error);
                    }
                },
                updateMap() {
                    // Implementação para atualizar o mapa com os dados de geoData
                    console.log('Atualizando mapa com os dados:', this.geoData);
                }
            }
        });
    </script>
</body>
</html>
