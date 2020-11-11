<template>
  <fieldset class="test">
    <legend>{{ legend }}</legend>
    <label :for="createId('script')" :class="disabled">
      Script:
    </label>
    <input name="script" :id="createId('script')" v-model="request.script" :disabled="disabled">

    <label :for="createId('url')" :class="disabled">
      Url:
    </label>
    <input name="url" :id="createId('url')" v-model="request.url" :disabled="disabled">

    <label :for="createId('body')">
      Body:
    </label>
    <input name="body" :id="createId('body')" v-model="request.body">

    <label :for="createId('header')" :class="disabled">
      Header:
    </label>
    <button v-on:click.stop.prevent="request.header = uuid"  :disabled="disabled">Copy uuid</button>
    <input name="header" :id="createId('header')" v-model="request.header" :disabled="disabled">
  </fieldset>
</template>

<script>
export default {
  name: "request",
  props: {
    request: Object,
    uuid: String,
    legend: String,
    disabled: String,
  },
  methods: {
    createId(field) {
      const separator = "_";
      return this.uuid + separator + this.legend.toLowerCase().replaceAll(' ', '_') + separator + field;
    },
  },
}
</script>

<style scoped>
body {
  font-family: 'Lato', sans-serif;
}
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
