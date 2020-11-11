import '../../css/app.css';

import Vue from 'vue';

// config
import '../config/consts';

// libs
import axios from 'axios';
import vueAxios from 'vue-axios';
import _ from 'lodash';

// components
import Upload from '../components/Module/Upload';
import Terminal from '../components/Terminal';
import MicroServiceTable from "../components/MicroServiceTable/MicroServiceTable";
import TestDefinition from "../components/MicroServiceLab/MicroServiceList/Test/TestDefinition";

// services
import '../service/autobahn';

Vue.use(vueAxios, axios);

/**
 * Create a fresh Vue Application instance
 */
const vue = new Vue({
    el: '#app',
    components: {Upload, Terminal, MicroServiceTable, TestDefinition},
    data() {
        return {
            log: null,
            searchQuery: '',
            gridColumns: [this.$uuid, this.$progressKey, this.$created, this.$updated, this.$connectWith],
            gridData: [],
            testData: [],
            uuid: '',
        }
    },
    mounted() {
        const conn = new ab.Session('ws://'+this.$BASE_HOST+':'+this.$WS_PORT,
            function () {
                conn.subscribe('entry_data', function (topic, data) {
                    vue.updateTerminal(data);
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
            data[vue.$testKey] = '';
            return data;
        },
        updateTerminal: function(data){
            if(data.log){
                vue.log = data.log;
            }
            if(data.request && data.headers && _.find(vue.gridData, function(row) { return row['uuid'] === data.headers})){
                vue.testData.push(data);
                vue.uuid = data.headers;
            }
        },
        insertRow: function(data){
            if(!_.find(vue.gridData, function(row) { return row[vue.$indexKey] === data[vue.$indexKey] })){
                vue.gridData.push(vue.init(data));
            }
        },
        deleteRow: function (uuid) {
            console.log(uuid);
            _.remove(vue.gridData, function (o) {
                    console.log(o.uuid === uuid);
                    return o.uuid === uuid
                }
            );
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
        },
        onUpload: function (uuid){
            this.insertRow({'uuid': uuid});
        },
        saveUuid: function (event) {
            console.log(event)
        }
    }
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


