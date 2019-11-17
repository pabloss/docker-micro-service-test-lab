import '../css/app.css';

import Vue from 'vue';
import axios from 'axios';
import vueAxios from 'vue-axios';
import Upload from './components/Upload';
import Terminal from './components/Terminal';
import Grid from "./components/Grid";

import './service/autobahn';
import './config/consts';

import _ from 'lodash';

Vue.use(vueAxios, axios);

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
        const conn = new ab.Session('ws://'+this.$BASE_HOST+':'+this.$WS_PORT,
            function () {
                conn.subscribe('entry_data', function (topic, data) {
                    vue.updateTerminal(data);
                    vue.updateRow(data);
                    vue.insertRow(data);
                });
            },
            function () {
                console.warn('WebSocket connection closed');
            },
            {'skipSubprotocolCheck': true}
        );
    },
    methods: {
        init: function (data) {
            data[vue.$initKey] = true;
            data[vue.$progressKey] = 0;
            data[vue.$maxKey] = 20;
            return data;
        },
        updateTerminal: function(data){
            if(data.log){
                vue.log = data.log;
            }
        },
        insertRow: function(data){
            if(!_.find(vue.gridData, function(row) { return row[vue.$indexKey] === data[vue.$indexKey] })){
                vue.gridData.push(vue.init(data));
            }
        },
        updateRow: function (data) {
            vue.gridData = _.map(vue.gridData, function(row) {
                if(row[vue.$indexKey] === data[vue.$indexKey]){
                    if(data.log && row.init){
                        row[vue.$initKey] = false;
                    }
                    return _.merge(row, data);
                } else{
                    return row;
                }
            });
        }
    }
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


