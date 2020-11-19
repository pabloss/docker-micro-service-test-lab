<template>
  <fieldset class="test">
    <legend>{{ legend }}</legend>

    <BasicInput :name="'script'" :disabled="disabled" :model="request.script" :section-name="legend" :unique-id="uuid" />
    <BasicInput :name="'url'" :disabled="disabled" :model="request.url" :section-name="legend" :unique-id="uuid" />
    <BasicInput :name="'body'" :disabled="null" :model="request.body" :section-name="legend" :unique-id="uuid" />

    <button v-on:click.stop.prevent="request.header = uuid"  :disabled="disabled">Copy uuid</button>

    <BasicInput :name="'header'" :disabled="disabled" :model="request.header" :section-name="legend" :unique-id="uuid" />
  </fieldset>
</template>

<script>
import BasicInput from "../../../BaseComponents/BaseInputComponent";
export default {
  components: {BasicInput},
  props: {
    request: Object,
    uuid: String,
    legend: String,
    disabled: String,
  },
}
</script>

<style scoped>
label {
  display: block;
  margin-top: 12px;
  font-family: 'Lato', sans-serif;
  font-weight: bold;
}

fieldset {
  padding: 4px;
  border-color: #f9f9f9;
  border-width: 1px;
}

legend {
  font-family: 'Lato', sans-serif;
  padding: 0 5px;
}

fieldset > button {
  display: block;
  margin: 5px 0;
  font-size: 1.3em;
}

.disabled {
  color: #AAA;
}
</style>
