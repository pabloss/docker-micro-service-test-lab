import '../css/app.css';

import './service/autobahn';

import Vue from 'vue';
import axios from 'axios';
import vueAxios from 'vue-axios';
import Upload from './components/Upload';
import Terminal from './components/Terminal';
import Grid from "./components/Grid";

Vue.use(vueAxios, axios);

Vue.prototype.$targetFileKey = 'target_file';
Vue.prototype.$targetDirKey = 'target_dir';
Vue.prototype.$progressKey = 'progress';
Vue.prototype.$BASE_HOST = 'service-test-lab-new.local';
const targetFile = 'target_file';
const targetDir = 'target_dir';
const progress = 'progress';
/**
 * Create a fresh Vue Application instance
 */
const vue = new Vue({
    el: '#app',
    components: {Upload, Terminal, Grid},
    data() {
        return {
            log: null,
            progress: null,
            max: null,
            error: null,
            searchQuery: '',
            gridColumns: [targetFile, targetDir, progress],
            gridData: [],
            init: true,
        }
    },
    mounted() {
        const conn = new ab.Session('ws://'+this.$BASE_HOST+':4444',
            function () {
                conn.subscribe('entry_data', function (topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    if(data.log){
                        vue.log = data.log;
                        vue.init = false;
                    }
                    vue.progress = data.progress;
                    vue.max = data.max;
                    vue.error = data.error;
                    if(data[targetFile] && data[targetDir]){
                        vue.gridData.push(data);
                    }
                });
            },
            function () {
                console.warn('WebSocket connection closed');
            },
            {'skipSubprotocolCheck': true}
        );
    }
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


