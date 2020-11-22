<template>
    <div id="micro-service-lab" @drop="handleDrop" @dragover.prevent>
        <MicroServicesCanvasContainer
                :clicks="clicks"
                :connectedMicroServices="connectedMicroServices"
                :lines="lines"
                :points="points"
        />
        <TestContainer v-for="(chosenMicroService, index) in microServiceList"
                       v-bind:key="chosenMicroService.id"
                       :unique-id="chosenMicroService.id"
                       :x="chosenMicroService.x"
                       :y="chosenMicroService.y"
                       @pointed="handleDrawLineStart"
        />
    </div>

</template>

<script>
import TestContainer from "./MicroServiceList/Test/TestContainer";
import MicroServicesCanvasContainer from "./MicroServicesCanvasContainer";
import add from '../../services/lab-add-microservice';
import DrawLineHandler from "../../services/draw-line-handler";

export default {
    components: {TestContainer, MicroServicesCanvasContainer},
    data() {
        return {
            microServiceList: [],
            connectedMicroServices: [],
            lines: [],
            points: [],
            clicks: 0,
            handler: null,
        }
    },
    created() {
        this.handler = DrawLineHandler(this.Constants, this.clicks, this.lines, this.points, this.connectedMicroServices);
    },
    methods: {
        handleDrop(e) {
            add(this.microServiceList, e.dataTransfer.getData('text/plain'), e.pageX, e.pageY);
        },
        handleDrawLineStart(microService) {
            this.handler.startLineDraw(microService)
        },
    },
}
</script>
<style scoped>
</style>
