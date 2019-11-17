import '../css/app.css';

import './service/autobahn';

import Vue from 'vue';
import axios from 'axios';
import vueAxios from 'vue-axios';
import Upload from './components/Upload';
import Terminal from './components/Terminal';
import Grid from "./components/Grid";
import _ from 'lodash';

Vue.use(vueAxios, axios);

Vue.prototype.$targetFileKey = 'target_file';
Vue.prototype.$targetDirKey = 'target_dir';
Vue.prototype.$progressKey = 'progress';
Vue.prototype.$indexKey = 'index';
Vue.prototype.$BASE_HOST = 'service-test-lab-new.local';

/**
 * Create a fresh Vue Application instance
 */
const vue = new Vue({
    el: '#app',
    components: {Upload, Terminal, Grid},
    data() {
        return {
            log: null,
            searchQuery: '',
            gridColumns: [this.$targetFileKey, this.$targetDirKey, this.$progressKey],
            gridData: []
        }
    },
    mounted() {
        const conn = new ab.Session('ws://'+this.$BASE_HOST+':4444',
            function () {
                conn.subscribe('entry_data', function (topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    if(data.log){
                        vue.log = data.log;
                    }
                    vue.gridData = _.map(vue.gridData, function(row) {
                        if(row[vue.$indexKey] === data[vue.$indexKey]){
                            if(data.log && row.init){
                                row.init = false;
                            }
                            return _.merge(row, data);
                        } else{
                            return row;
                        }
                    });
                    if(!_.find(vue.gridData, function(row) { return row[vue.$indexKey] === data[vue.$indexKey] })){
                        data.init = true;
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


