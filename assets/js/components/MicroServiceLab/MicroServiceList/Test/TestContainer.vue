<template>
    <div class="test-container" @contextmenu.prevent="handleRightClick">
        <DraggableBaseComponent :unique-id="uniqueId" :x="x" :y="y">
            {{ uniqueId }}
            <ModalBaseComponent v-if="showModal" @close="showModal = false">
                <template v-slot:body>
                    <TestDefinition :uuid="uniqueId"/>
                </template>
            </ModalBaseComponent>
        </DraggableBaseComponent>
    </div>
</template>

<script>
import DraggableBaseComponent from "../../../BaseComponents/DraggableBaseComponent";
import ModalBaseComponent from "../../../BaseComponents/ModalBaseComponent";
import TestDefinition from "./TestDefinition";

export default {
    components: {DraggableBaseComponent, ModalBaseComponent, TestDefinition},
    props: {
        uniqueId: String,
        x: Number,
        y: Number,
    },
    data() {
        return {
            showModal: false,
        }
    },
    methods: {
        handleRightClick(e) {
            this.showModal = true;
        },
    },
}
</script>

<style scoped>
</style>
