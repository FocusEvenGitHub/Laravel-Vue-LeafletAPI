<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <!-- Use Link directly without an additional <a> tag -->
      <Link :href="route('home')" class="navbar-brand">
        Mapa de Rodovias
      </Link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto"> 
          <li class="nav-item">
            <!-- Use Link directly for navigation -->
            <Link :href="route('trechos.index')" class="nav-link">
              Listagem
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
