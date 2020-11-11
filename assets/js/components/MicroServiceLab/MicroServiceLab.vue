<template>
  <div>
    <div id="canvas-micro-services" @dragover.prevent @drop="handleDrop"></div>
    <ChosenMicroServiceList :micro-service-list="microServiceList"/>
  </div>

</template>

<script>
import ChosenMicroServiceList from "./MicroServiceList/ChosenMicroServiceList";
export default {
  name: "micro-service-lab",
  components: {ChosenMicroServiceList},
  data() {
    return {
      microServiceList: [],
    }
  },
  methods: {
    handleDrop(e) {
      if(!this._getMicroService(this.microServiceList, e.dataTransfer.getData('text/plain'))){
        this._addMicroServiceConfig(this.microServiceList, e.dataTransfer.getData('text/plain'), e.pageX, e.pageY);
      }
    },
    _getMicroService(microServiceList, uuid) {
      return _.find(microServiceList, ms => ms && ms.uuid && ms.uuid === uuid);
    },
    _addMicroServiceConfig(microServiceList, uuid, x, y) {
      microServiceList.push({uuid: uuid, x: x, y: y,})
    },
  },
}
</script>

<style scoped>
#canvas-micro-services {
  position: relative;
  background-color: darkgrey;
  outline: 2px dashed #777;
  outline-offset: -10px;
  width: 1200px;
  height: 500px;
}

/*font-family: 'Noto Serif', serif;*/
</style>
