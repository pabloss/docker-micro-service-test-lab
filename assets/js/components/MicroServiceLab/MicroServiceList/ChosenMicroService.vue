<template>
  <div
      :style="positionStyle"
      draggable="true"
      @dragover.prevent
      @dragstart="handleDragStart"
      @contextmenu.prevent="handleRightClick"
  >
    {{ microService.uuid }}
    <TestContainer
        v-if="showModal"
        :uuid="microService.uuid"
        @close="showModal = false"
    ></TestContainer>
  </div>
</template>

<script>
import TestContainer from "./Test/TestContainer";
export default {
  components: {TestContainer},
  props: {
    microService: Object,
  },
  data() {
    return {
      showModal: false,
    }
  },
  methods: {
    handleDragStart(e) {
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/plain', this.microService.uuid);
      return false;
    },
    handleRightClick(e) {
      this.showModal = true;
    },
  },
  computed: {
    positionStyle() {
      return {
        position: 'absolute',
        display: 'block',
        left: this.microService.x + 'px',
        top: this.microService.y + 'px',
      }
    },
  },
}
</script>

<style scoped>

</style>
