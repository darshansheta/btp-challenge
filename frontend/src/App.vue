<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <Card>
    <template #content>
      <RouterView />
    </template>
  </Card>
</template>

<style scoped></style>
