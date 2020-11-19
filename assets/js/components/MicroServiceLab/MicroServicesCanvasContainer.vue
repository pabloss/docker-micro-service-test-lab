<template>
    <div id="canvas-micro-services">
        <v-stage ref="stage" :config="{width: 1200, height: 500, }">
            <v-layer ref="layer">
                <v-line ref="line" v-for="(line, index) in lines" :config="{
            points: line,
            stroke: 'red',
            strokeWidth: 8,
            lineCap: 'round',
            lineJoin: 'round',
          }" :key="index">
                </v-line>
            </v-layer>
        </v-stage>
    </div>
</template>

<script>
export default {
    props:  {
        lines: Array,
        points: Array,
        connectedMicroServices: Array,
        clicks: Number,
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
</style>
