<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <!-- <RouterLink to="/">Home</RouterLink> -->
      </nav>
    </div>
  </header>
  <Card>
    <template #content>
      <RouterView />
    </template>
  </Card>
</template>

<style scoped></style>
