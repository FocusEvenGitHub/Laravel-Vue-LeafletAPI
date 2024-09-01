<template>
    <div>
      <div class="filters">
        <!-- Filtros -->
        <label for="date">Data de Referência:</label>
        <input type="date" v-model="filters.date" id="date">
  
        <label for="uf">Unidade da Federação:</label>
        <select v-model="filters.uf" id="uf">
          <option v-for="uf in ufs" :key="uf.code" :value="uf.code">{{ uf.name }}</option>
        </select>
  
        <label for="rodovia">Rodovia:</label>
        <select v-model="filters.rodovia" id="rodovia">
          <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia.id">{{ rodovia.name }}</option>
        </select>
  
        <label for="tipo">Tipo de Trecho:</label>
        <select v-model="filters.tipo" id="tipo">
          <option v-for="tipo in tipos" :key="tipo" :value="tipo">{{ tipo }}</option>
        </select>
  
        <label for="km-inicial">Quilometragem Inicial:</label>
        <input type="number" v-model.number="filters.kmInicial" id="km-inicial">
  
        <label for="km-final">Quilometragem Final:</label>
        <input type="number" v-model.number="filters.kmFinal" id="km-final">
      </div>
  
      <div id="map" style="height: 500px;"></div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import 'leaflet/dist/leaflet.css';
  import L from 'leaflet';
  
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
  
      const ufs = ref([
        { code: 'SP', name: 'São Paulo' },
        { code: 'RJ', name: 'Rio de Janeiro' }
        // Adicione mais UFs conforme necessário
      ]);
  
      const rodovias = ref([
        { id: 1, name: 'Rodovia A' },
        { id: 2, name: 'Rodovia B' }
        // Adicione mais rodovias conforme necessário
      ]);
  
      const tipos = ref(['Tipo A', 'Tipo B', 'Tipo C']);
  
      const initMap = () => {
        const map = L.map('map').setView([51.505, -0.09], 13);
  
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
        }).addTo(map);
  
        // Adicione lógica para atualizar o mapa com base nos filtros aqui
      };
  
      onMounted(() => {
        initMap();
      });
  
      return {
        filters,
        ufs,
        rodovias,
        tipos
      };
    }
  };
  </script>
  
  <style>
  .filters {
    margin-bottom: 20px;
  }
  
  .filters label {
    margin-right: 10px;
  }
  </style>
  