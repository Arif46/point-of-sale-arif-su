const dashboardRoutes = (prop) => [
    {
        path: 'dashboard',
        name: prop + '.dashboard',
        meta: { auth: true, name: 'Editable' },
        component: () => import('../pages/Dasbhoard.vue')
    }
]

const childRoutes = (prop) => [
    {
      path: 'component',
      name: prop + '.component',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/component/List.vue')
    },
    {
        path: 'demo',
        name: prop + '.demo',
        meta: { auth: true, name: 'Editable' },
        component: () => import('../pages/component/Demo.vue')
    },
    {
      path: 'module',
      name: prop + '.module',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/module/List.vue')
    },
    {
      path: 'service',
      name: prop + '.service',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/service/List.vue')
    },
    {
      path: 'menu',
      name: prop + '.menu',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/menu/List.vue')
    }
]

const routes = [
    {
        path: '/common-service',
        name: 'common_service',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: false },
        children: dashboardRoutes('common_service')
    },
    {
        path: '/common-service/menu',
        name: 'common_service.menu',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: true },
        children: childRoutes('common_service.menu')
    }
]

export default routes
