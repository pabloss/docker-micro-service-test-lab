import '../css/app.css';

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
