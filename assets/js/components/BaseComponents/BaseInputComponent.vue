<template>
    <div>
        <label :class="disabled" :for="createId(name)">
            {{ name | capitalize }}:
        </label>
        <input :id="createId(name)"
               v-bind:value="value"
               v-on:input="$emit('input', $event.target.value)"
               :disabled="disabled"
               :name="name"
        />
    </div>
</template>

<script>
export default {
    props: {
        value: String,
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
