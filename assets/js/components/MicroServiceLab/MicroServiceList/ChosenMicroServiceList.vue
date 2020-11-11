<template>
  <div>
    <ChosenMicroService v-for="(chosenMicroService, index) in microServiceList" :micro-service="chosenMicroService" v-bind:key="index"></ChosenMicroService>
  </div>
</template>

<script>
import ChosenMicroService from "./ChosenMicroService";
export default {
  components: {ChosenMicroService},
  props: {
    microServiceList: Array,
  }
}
</script>

<style scoped>

</style>
