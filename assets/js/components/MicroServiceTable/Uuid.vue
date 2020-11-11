<template>
  <a :href="`http://${this.$BASE_HOST}/micro-service/${uuid}`"
     @click.stop.prevent
     draggable="true"
     @dragstart="handleDragStart"
  >{{ uuid }}</a>
</template>

<script>
export default {
  name: "Uuid",
  props: {
    microServiceUuid: String
  },
  data() {
    return {
      uuid: this.microServiceUuid,
    }
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
