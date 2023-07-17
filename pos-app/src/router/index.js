import Vue from 'vue'
import VueRouter from 'vue-router'
import Store from '../store'
import DesginerServiceRoute from '../modules/designer-service/configuration/routes'
import AuthServiceAuthRoute from '../modules/auth-service/auth/routes'
import CommonServiceMenuRoute from '../modules/common-service/menu/routes'
import CommonServiceAddressManagementRoute from '../modules/common-service/address-management/routes'
import CommonServiceProductManagementRoute from '../modules/common-service/product-management/routes'
import CommonServiceContactManagementRoute from '../modules/common-service/contact-management/routes'

Vue.use(VueRouter)

const defaultRoutes = [
  {
    path: '/',
    name: 'auth.login',
    component: () => import('../modules/auth-service/auth/pages/Login.vue')
  },
  {
    path: '/button',
    name: 'Button',
    component: () => import('../views/ui-elements/Button.vue')
  },
  {
    path: '/modal',
    name: 'Modal',
    component: () => import('../views/ui-elements/Modal.vue')
  },
  {
    path: '/breadcrumb',
    name: 'Breadcrumb',
    component: () => import('../views/ui-elements/Breadcrumb.vue')
  },
  {
    path: '/badge',
    name: 'Badge',
    component: () => import('../views/ui-elements/Badge.vue')
  },
  {
    path: '/tabs',
    name: 'Tabs',
    component: () => import('../views/ui-elements/Tabs.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/ui-elements/Login.vue')
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import('../views/ui-elements/Signup.vue')
  },
  {
    path: '/404',
    name: '404',
    component: () => import('../views/ui-elements/404.vue')
  },
  {
    path: '/preloader',
    name: 'Preloader',
    component: () => import('../views/ui-elements/Preloader.vue')
  },
  {
    path: '/list-group',
    name: 'ListGroup',
    component: () => import('../views/ui-elements/ListGroup.vue')
  },
  {
    path: '/table',
    name: 'Table',
    component: () => import('../views/ui-elements/Table.vue')
  },
  {
    path: '/card',
    name: 'Card',
    component: () => import('../views/ui-elements/Card.vue')
  },
  {
    path: '/accordion',
    name: 'Accordion',
    component: () => import('../views/ui-elements/Accordion.vue')
  },
  {
    path: '/pagination',
    name: 'Pagination',
    component: () => import('../views/ui-elements/Pagination.vue')
  },
  {
    path: '/alert',
    name: 'Alert',
    component: () => import('../views/ui-elements/Alert.vue')
  },
  {
    path: '/tooltip',
    name: 'Tooltip',
    component: () => import('../views/ui-elements/Tooltip.vue')
  },
  {
    path: '/form',
    name: 'Form',
    component: () => import('../views/ui-elements/Form.vue')
  }
]
const routes = [
  ...defaultRoutes,
  ...AuthServiceAuthRoute,
  ...DesginerServiceRoute,
  ...CommonServiceMenuRoute,
  ...CommonServiceAddressManagementRoute,
  ...CommonServiceProductManagementRoute,
  ...CommonServiceContactManagementRoute
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  linkActiveClass: 'active',
  linkExactActiveClass: 'active',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    const accessToken = Store.state.Auth.accessToken
    const authUser = Store.state.Auth.authUser
    if (accessToken && authUser) {
      return next()
    }

    return next({ path: '/auth/login' })
  }

  next()
})

export default router
