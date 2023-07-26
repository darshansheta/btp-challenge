<script>
export default {
  props: {
    icon: String,
  },
  computed: {
    iconUrl() {
      return `http://openweathermap.org/img/w/${this.icon}.png`;
    },
  },
};
</script>
<template>
  <img alt="logo" :src="iconUrl" width="30" />
</template>
