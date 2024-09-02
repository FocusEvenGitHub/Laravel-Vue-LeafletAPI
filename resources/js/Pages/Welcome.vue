<script setup>
import { ref, onMounted, watch } from 'vue';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import axios from 'axios';
import NavBar from '@/Components/NavBar.vue';
import { Head } from '@inertiajs/vue3';




    const filters = ref({
      date: '',
      uf: '',
      rodovia: '',
      tipo: '',
      kmInicial: null,
      kmFinal: null
    });

    const ufs = ref([]);
    const rodovias = ref([]);
    const tipos = ref([]);
    const map = ref(null); 
    const geoData = ref(null);
    

    const fetchUfs = async () => {
      try {
        const response = await axios.get('/api/ufs');
        ufs.value = response.data.map(uf => ({
          uf: uf.uf,
          id: uf.id
        }));
      } catch (error) {
        console.error('Erro ao carregar UFs:', error);
      }
    };

    const fetchRodovias = async (ufId = null) => {
      try {
        const response = await axios.get('/api/rodovias', {
          params: ufId ? { uf_id: ufId } : {},
        });
        rodovias.value = response.data.map(rodovia => ({
          rodovia: rodovia.rodovia,
          id: rodovia.id
        }));
      } catch (error) {
        console.error('Erro ao carregar rodovias:', error);
      }
    };

    const fetchTipos = async () => {
      if (!filters.value.uf || !filters.value.rodovia) return;
      try {
        const response = await axios.get('/api/tipos', {
          params: {
            uf: filters.value.uf,
            br: filters.value.rodovia,
            data_referencia: filters.value.date
          }
        });
        if (response.data.success) {
          tipos.value = response.data.tipos.lista_tp_trecho.split(',').map(tipo => tipo.trim());
        } else {
          console.error('Erro ao buscar tipos de rodovias:', response.data.message);
        }
      } catch (error) {
        console.error('Erro ao buscar tipos de rodovias:', error);
      }
    };

    const saveTrecho = async () => {
      try {
        const ufId = ufs.value.find(uf => uf.uf === filters.value.uf)?.id;
        const rodoviaId = rodovias.value.find(rodovia => rodovia.rodovia === filters.value.rodovia)?.id;

        if (!ufId || !rodoviaId) {
          alert('UF ou rodovia inválida.');
          return;
        }

        const response = await axios.post('/api/trechos', {
          data_referencia: filters.value.date,
          uf_id: ufId,
          rodovia_id: rodoviaId,
          quilometragem_inicial: filters.value.kmInicial,
          quilometragem_final: filters.value.kmFinal,
          tipo: filters.value.tipo, 
        });

        if (response.data.success) {
          alert('Trecho salvo com sucesso!');
          geoData.value = response.data.geo; // Atualizar dados do GeoJSON
          updateMap(); // Atualizar o mapa
          // Obtém o nível de zoom atual
        } else {
          alert('Erro ao salvar trecho.');
        }
      } catch (error) {
        console.error('Erro ao salvar trecho:', error);
      }
    };

    const initMap = () => {
      map.value = L.map('map',{
        zoom: 5, // Initial zoom level
        minZoom: 5, // Minimum zoom level
        maxZoom: 18, // Maximum zoom level (adjust as needed)
      }).setView([-13.505, -53.09], 5);



      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map.value);

      // Se há dados GeoJSON ao iniciar, adicione-os
      if (geoData.value) {
        L.geoJSON(geoData.value).addTo(map.value);
      }
    };

    const updateMap = () => {
      if (map.value && geoData.value) {
        // Limpar o mapa antes de adicionar novos dados
        map.value.eachLayer(layer => {
          if (layer instanceof L.GeoJSON) {
            map.value.removeLayer(layer);
          }
        });

        // Adicionar novos dados GeoJSON
        const geoJsonLayer = L.geoJSON(geoData.value).addTo(map.value);

        // Ajustar o mapa para exibir todos os dados do GeoJSON
        map.value.fitBounds(geoJsonLayer.getBounds());
      }
    };

    onMounted(() => {
      initMap();
      fetchUfs();
    });

    watch(() => filters.value.uf, (newUf) => {
      if (newUf) {
        const selectedUf = ufs.value.find(uf => uf.uf === newUf);
        fetchRodovias(selectedUf.id);
      } else {
        rodovias.value = [];
        tipos.value = [];
      }
    });

    watch(() => filters.value.rodovia, () => {
      fetchTipos();
    });
 
</script>
<template>
    <Head title="Mapa de Rodovias" />

    <NavBar/>
  <div class="container mt-4">
    <div class="d-flex justify-content-center">
      <span class="loader"></span>
    </div>
    
    <div class="card p-4 mb-4">
      <div class="row g-3">
        <div class="col-md-2">
          <label for="date" class="form-label">Data de Referência:</label>
          <input type="date" class="form-control" v-model="filters.date" id="date">
        </div>

        <div class="col-md-2">
          <label for="uf" class="form-label">Unidade da Federação:</label>
          <select class="form-select" v-model="filters.uf" id="uf">
            <option value="">Selecione uma UF</option>
            <option v-for="uf in ufs" :key="uf.id" :value="uf.uf">{{ uf.uf }}</option>
          </select>
        </div>

        <div class="col-md-2">
          <label for="rodovia" class="form-label">Rodovia:</label>
          <select class="form-select" v-model="filters.rodovia" id="rodovia" :disabled="!filters.uf">
            <option value="">Selecione uma rodovia</option>
            <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia.rodovia">{{ rodovia.rodovia }}</option>
          </select> 
        </div>

        <div class="col-md-2">
          <label for="tipo" class="form-label">Tipo de Trecho:</label>
          <select class="form-select" v-model="filters.tipo" id="tipo" :disabled="!filters.rodovia || tipos.length === 0">
            <option value="">Selecione um tipo</option>
            <option v-for="tipo in tipos" :key="tipo" :value="tipo">{{ tipo }}</option>
          </select>
        </div>

        <div class="col-md-2">
          <label for="km-inicial" class="form-label">Quilometragem Inicial:</label>
          <input type="number" class="form-control" v-model.number="filters.kmInicial" id="km-inicial">
        </div>

        <div class="col-md-2">
          <label for="km-final" class="form-label">Quilometragem Final:</label>
          <input type="number" class="form-control" v-model.number="filters.kmFinal" id="km-final">
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button @click="saveTrecho" class="btn btn-primary">Salvar Trecho</button>
      </div>
    </div>

    <div id="map" class="border" style="height: 700px;"></div>
  </div>
</template>
  

<script>

export default {
  name: 'MapPage',
  setup() {
    const filters = ref({
      date: '',
      uf: '',
      rodovia: '',
      tipo: '',
      kmInicial: null,
      kmFinal: null
    });

    const ufs = ref([]);
    const rodovias = ref([]);
    const tipos = ref([]);
    const map = ref(null); // Referência ao mapa
    const geoData = ref(null); // Dados GeoJSON
    

    const fetchUfs = async () => {
      try {
        const response = await axios.get('/api/ufs');
        ufs.value = response.data.map(uf => ({
          uf: uf.uf,
          id: uf.id
        }));
      } catch (error) {
        console.error('Erro ao carregar UFs:', error);
      }
    };

    const fetchRodovias = async (ufId = null) => {
      try {
        const response = await axios.get('/api/rodovias', {
          params: ufId ? { uf_id: ufId } : {},
        });
        rodovias.value = response.data.map(rodovia => ({
          rodovia: rodovia.rodovia,
          id: rodovia.id
        }));
      } catch (error) {
        console.error('Erro ao carregar rodovias:', error);
      }
    };

    const fetchTipos = async () => {
      if (!filters.value.uf || !filters.value.rodovia) return;
      try {
        const response = await axios.get('/api/tipos', {
          params: {
            uf: filters.value.uf,
            br: filters.value.rodovia,
            data_referencia: filters.value.date
          }
        });
        if (response.data.success) {
          tipos.value = response.data.tipos.lista_tp_trecho.split(',').map(tipo => tipo.trim());
        } else {
          console.error('Erro ao buscar tipos de rodovias:', response.data.message);
        }
      } catch (error) {
        console.error('Erro ao buscar tipos de rodovias:', error);
      }
    };

    const saveTrecho = async () => {
      try {
        const ufId = ufs.value.find(uf => uf.uf === filters.value.uf)?.id;
        const rodoviaId = rodovias.value.find(rodovia => rodovia.rodovia === filters.value.rodovia)?.id;

        if (!ufId || !rodoviaId) {
          alert('UF ou rodovia inválida.');
          return;
        }

        const response = await axios.post('/api/trechos', {
          data_referencia: filters.value.date,
          uf_id: ufId,
          rodovia_id: rodoviaId,
          quilometragem_inicial: filters.value.kmInicial,
          quilometragem_final: filters.value.kmFinal,
          tipo: filters.value.tipo, 
        });

        if (response.data.success) {
          alert('Trecho salvo com sucesso!');
          geoData.value = response.data.geo; // Atualizar dados do GeoJSON
          updateMap(); // Atualizar o mapa
          // Obtém o nível de zoom atual
        } else {
          alert('Erro ao salvar trecho.');
        }
      } catch (error) {
        console.error('Erro ao salvar trecho:', error);
      }
    };

    const initMap = () => {
      map.value = L.map('map',{
        zoom: 5, // Initial zoom level
        minZoom: 5, // Minimum zoom level
        maxZoom: 18, // Maximum zoom level (adjust as needed)
      }).setView([-13.505, -53.09], 5);



      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map.value);

      // Se há dados GeoJSON ao iniciar, adicione-os
      if (geoData.value) {
        L.geoJSON(geoData.value).addTo(map.value);
      }
    };

    const updateMap = () => {
      if (map.value && geoData.value) {
        // Limpar o mapa antes de adicionar novos dados
        map.value.eachLayer(layer => {
          if (layer instanceof L.GeoJSON) {
            map.value.removeLayer(layer);
          }
        });

        // Adicionar novos dados GeoJSON
        const geoJsonLayer = L.geoJSON(geoData.value).addTo(map.value);

        // Ajustar o mapa para exibir todos os dados do GeoJSON
        map.value.fitBounds(geoJsonLayer.getBounds());
      }
    };

    onMounted(() => {
      initMap();
      fetchUfs();
    });

    watch(() => filters.value.uf, (newUf) => {
      if (newUf) {
        const selectedUf = ufs.value.find(uf => uf.uf === newUf);
        fetchRodovias(selectedUf.id);
      } else {
        rodovias.value = [];
        tipos.value = [];
      }
    });

    watch(() => filters.value.rodovia, () => {
      fetchTipos();
    });

    return {
      filters,
      ufs,
      rodovias,
      tipos,
      saveTrecho,
      map,
    };
  },
  };
</script>

<style>
.filters {
  margin-bottom: 20px;
}

.filters label {
  margin-right: 10px;
}

.loader {
        top: 50%;
        right: 50%;
        width: 80px;
        height: 80px;
        border-radius: 100%;
        position: relative;
        animation: rotate 1s linear infinite;
        display: none;
        position: absolute;
        z-index: 1000;
        background: rgb(0, 0, 0, 0.5);
        outline: rgb(0, 0, 0, 0.5) solid 4px;
      }
      .loader::before , .loader::after {
        content: "";
        box-sizing: border-box;
        position: absolute;
        inset: 0px;
        border-radius: 50%;
        border: 5px solid #FFF;
        animation: prixClipFix 2s linear infinite ;
      }
      .loader::after{
        inset: 8px;
        transform: rotate3d(90, 90, 0, 180deg );
        border-color: #0059ff;
      }

      @keyframes rotate {
        0%   {transform: rotate(0deg)}
        100%   {transform: rotate(360deg)}
      }

      @keyframes prixClipFix {
          0%   {clip-path:polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
          50%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
          75%, 100%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
      }
</style>
