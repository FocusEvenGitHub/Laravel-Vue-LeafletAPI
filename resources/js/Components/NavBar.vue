<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <Link :href="route('home')" class="navbar-brand">
        Mapa de Rodovias
      </Link>
      <div class="navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto"> 
          <li class="nav-item">
            <Link :href="route('trechos.index')" class="nav-link">
              Listagem
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
