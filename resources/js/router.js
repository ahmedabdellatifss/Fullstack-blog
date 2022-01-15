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
import role from './admin/pages/role.vue'
import assignRole from './admin/pages/assignRole.vue'


const routes = [

    // Project routes
    {
        path: '/',
        component: home,
        name: 'home'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
    {
        path: '/tags',
        component: tag,
        name: 'tags'
    },
    {
        path: '/category',
        component: category,
        name: 'category'
    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'
    },
    {
        path: '/role',
        component: role,
        name: 'role'
    },
    {
        path: '/assignRole',
        component: assignRole,
        name: 'assignRole'
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
