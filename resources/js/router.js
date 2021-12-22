import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import firstPage from './components/pages/myFirstVuePage.vue'
import newRoutePage from './components/pages/newRoutePage.vue'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'
import usecom from './vuex/usecom.vue'

// project pages
import home from './components/pages/home.vue'
import tag from './admin/pages/tags.vue'
import category from './admin/pages/category.vue'
import adminusers from './admin/pages/adminusers.vue'
import login from './admin/pages/login.vue'


const routes = [

    // Project routes
    {
        path: '/',
        component: home
    },
    {
        path: '/login',
        component: login
    },
    {
        path: '/tags',
        component: tag
    },
    {
        path: '/category',
        component: category
    },
    {
        path: '/adminusers',
        component: adminusers
    },





    //   Test Route
    {
        path: '/testvuex',
        component: usecom
    },
    {
        path: '/my-new-vue-route',
        component: firstPage
    },
    {
        path: '/new-route',
        component: newRoutePage
    },

    // Vue hooks
    {
        path: '/hooks',
        component: hooks
    },
    // more basic
    {
        path: '/methods',
        component: methods
    },
]


export default new Router({
    mode: 'history',
    routes
})
