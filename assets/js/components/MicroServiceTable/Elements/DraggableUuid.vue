<template>
  <a :href="`http://${this.$BASE_HOST}/micro-service/${uuid}`"
     @click.stop.prevent
     draggable="true"
     @dragstart="handleDragStart"
  >{{ uuid }}</a>
</template>

<script>
export default {
  props: {
    uuid: String
  },
  methods: {
    handleDragStart(e) {
      e.dataTransfer.effectAllowed = 'copy';
      e.dataTransfer.setData('text/plain', this.uuid);
      return false;
    },
  },
}
</script>

<style scoped>

</style>
