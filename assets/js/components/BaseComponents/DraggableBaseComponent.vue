<template>
    <div
            :style="positionStyle"
            draggable="true"
            @click="handleDrawLineStart"
            @dragstart="handleDragStart"
            @dragover.prevent
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        uniqueId: String,
        x: Number,
        y: Number,
    },
    methods: {
        handleDrawLineStart(e) {
            this.$parent.$emit('pointed', {
                id: this.uniqueId,
                x: e.pageX - e.offsetX - e.target.parentElement.parentElement.offsetLeft,
                y: e.pageY - e.offsetY - e.target.parentElement.parentElement.offsetTop,
            });
        },
        handleDragStart(e) {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.uniqueId);
            return false;
        },
    },
    computed: {
        positionStyle() {
            return {
                position: 'absolute',
                display: 'block',
                left: this.x + 'px',
                top: this.y + 'px',
            }
        },
    },
}
</script>

<style scoped>

</style>
