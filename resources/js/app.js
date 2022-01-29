require('./bootstrap');
window.Vue = require('vue')
import router from './router'
import store from './store'

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);

import Editor from 'vue-editor-js'
import jsonToHtml from './jsonToHtml'
import common from './common'

Vue.mixin(common)
Vue.mixin(jsonToHtml)

Vue.component('mainapp' , require('./components/mainapp.vue').default)

Vue.use(Editor)

const app = new Vue({
    el: '#app',
    router,
    store
});
