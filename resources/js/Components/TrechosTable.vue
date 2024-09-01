<script setup>
import { Link } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';

</script>

<template>
    <div class="container mt-4">
      <h1 class="mb-4">Tabela de Trechos</h1>
      
      <form class="d-flex mb-4">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-secondary" type="submit">Search</button>
      </form>
      
      <table class="table table-striped">
        <thead>
          <tr>
            <th>UF</th>
            <th>Rodovia</th>
            <th>Quilometragem Inicial</th>
            <th>Quilometragem Final</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="trecho in trechos.data" :key="trecho.id">
            <td>{{ trecho.uf.uf }}</td>
            <td>{{ trecho.rodovia.rodovia }}</td>
            <td>{{ trecho.quilometragem_inicial }}</td>
            <td>{{ trecho.quilometragem_final }}</td>
          </tr>
        </tbody>
      </table>
      
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item">
            <button @click="fetchTrechos(trechos.prev_page_url)" :disabled="!trechos.prev_page_url" class="page-link">Anterior</button>
          </li>
          <li class="page-item">
            <button @click="fetchTrechos(trechos.next_page_url)" :disabled="!trechos.next_page_url" class="page-link">Próximo</button>
          </li>
        </ul>
      </nav>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  export default {
    name: 'TrechosTable',
    setup() {
      const trechos = ref({ data: [], next_page_url: null, prev_page_url: null });
  
      const fetchTrechos = async (url = '/api/trechos') => {
        try {
          const response = await axios.get(url);
          trechos.value = response.data;
        } catch (error) {
          console.error('Erro ao carregar trechos:', error);
        }
      };
  
      onMounted(() => {
        fetchTrechos();
      });
  
      return {
        trechos,
        fetchTrechos,
      };
    },
  };
  </script>
  
  <style>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  table, th, td {
    border: 1px solid black;
  }
  
  th, td {
    padding: 8px;
    text-align: left;
  }
  
  .pagination {
    margin-top: 20px;
  }
  
  .pagination button {
    margin-right: 10px;
  }
  </style>
  