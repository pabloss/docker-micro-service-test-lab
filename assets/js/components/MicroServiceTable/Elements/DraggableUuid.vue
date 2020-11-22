<template>
    <a :href="`http://${this.Constants.BASE_HOST}/micro-service/${uuid}`"
       draggable="true"
       @dragstart="handleDragStart"
       @click.stop.prevent
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
