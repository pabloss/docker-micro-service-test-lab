import '../css/app.css';

import Vue from 'vue';

// libs
import axios from 'axios';
import vueAxios from 'vue-axios';
import VueKonva from 'vue-konva';
import drag from 'v-drag';

// config
import Constants from "./config/Constants";
Vue.use(Constants);

// components
import Upload from './components/Module/Upload';
import TerminalContainer from './components/Module/TerminalContainer';
import MicroServiceTableContainer from "./components/MicroServiceTable/MicroServiceTableContainer";
import MicroServiceLabContainer from "./components/MicroServiceLab/MicroServiceLabContainer";

Vue.use(vueAxios, axios);
Vue.use(VueKonva);
Vue.use(drag);

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

/**
 * Create a fresh Vue Application instance
 */
const vue = new Vue({
    el: '#app',
    components: {Upload, TerminalContainer, MicroServiceTableContainer, MicroServiceLabContainer},
    template: `
        <div id="lab">
        <Upload />

        <MicroServiceLabContainer/>

        <MicroServiceTableContainer/>

        <TerminalContainer/>
        </div>
    `
});
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


