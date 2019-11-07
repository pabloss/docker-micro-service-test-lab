import '../css/app.css';

import './service/autobahn';

import Vue from 'vue';
import axios from 'axios';
import vueAxios from 'vue-axios';
import { upload } from './service/file-upload.service';
import Upload from './components/Upload';

Vue.use(vueAxios, axios, upload);
/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    components: {Upload}
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

const conn = new ab.Session('ws://service-test-lab-new.local:4444',
    function () {
        conn.subscribe('message', function (topic, data) {
            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
            console.log( data.log);
        });
    },
    function () {
        console.warn('WebSocket connection closed');
    },
    {'skipSubprotocolCheck': true}
);
