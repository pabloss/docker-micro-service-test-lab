<template>
  <div>
    <label :for="createId(name)" :class="disabled">
      {{ name | capitalize }}:
    </label>
    <input :name="name" :id="createId(name)" v-model="model" :disabled="disabled" />
  </div>
</template>

<script>
export default {
  props: {
    model: String,
    uniqueId: String,
    name: String,
    disabled: String,
    sectionName: String,
  },
  methods: {
    createId(field) {
      const separator = "_";
      return this.uniqueId + separator + this.sectionName.toLowerCase().replaceAll(' ', '_') + separator + field;
    },
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
</style>
