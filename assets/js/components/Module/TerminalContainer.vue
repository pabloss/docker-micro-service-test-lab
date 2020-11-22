<template>
    <Terminal
            :greeting="false"
            :log="log"
            :prompt="' '"
            :show-header="false"
            :show-help-message="false"
            :show-initial-cd="false"
    />
</template>

<script>
// services
import '../../services/autobahn';

// components
import Terminal from "../BaseComponents/Module/Terminal";

export default {
    components: {Terminal},
    data() {
        return {
            log: '',
        }
    },
    mounted() {
        const conn = new ab.Session(
                'ws://' + this.Constants.BASE_HOST + ':' + this.Constants.WS_PORT,
                () => {
                    conn.subscribe('entry_data', (topic, data) => {
                        this.updateTerminal(data)
                    })
                },
                () => {
                    console.warn('WebSocket connection closed')
                },
                {'skipSubprotocolCheck': true}
        );
    },
    methods: {
        updateTerminal: function (data) {
            if (data.log) {
                this.log = data.log;
            }
        },
    },
}
</script>

<style scoped>

</style>
