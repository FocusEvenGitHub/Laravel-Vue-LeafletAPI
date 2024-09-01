<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <Link :href="route('home')">
        <a class="navbar-brand">Mapa de Rodovias</a>
      </Link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class=" navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto"> 
          <Link :href="route('trechos.index')">
          <li class="nav-item">
            <a class="nav-link">Listagem</a>
          </li>
         </Link>
        </ul>
      </div>
    </div>
  </nav>
</template>