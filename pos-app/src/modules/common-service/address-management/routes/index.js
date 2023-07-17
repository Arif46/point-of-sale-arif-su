// const dashboardRoutes = (prop) => [
//     {
//         path: 'dashboard',
//         name: prop + '.dashboard',
//         meta: { auth: true, name: 'Editable' },
//         component: () => import('../pages/Dasbhoard.vue')
//     }
// ]

const childRoutes = (prop) => [
    {
      path: 'division',
      name: prop + '.division',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/division/List.vue')
    },
    {
      path: 'district',
      name: prop + '.district',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/district/List.vue')
    },
    {
      path: 'upazila',
      name: prop + '.upazila',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/upazila/List.vue')
    },
    {
      path: 'paurashava',
      name: prop + '.paurashava',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/paurashava/List.vue')
    },
    {
      path: 'union',
      name: prop + '.union',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/union/List.vue')
    },
    {
      path: 'ward',
      name: prop + '.ward',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/ward/List.vue')
    },
    {
      path: 'bank',
      name: prop + '.bank',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/bank/List.vue')
    },
    {
      path: 'branch',
      name: prop + '.branch',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/branch/List.vue')
    },
    {
      path: 'city-corporation',
      name: prop + '.city_corporation',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/city-corporation/List.vue')
    }
]

const routes = [
    // {
    //     path: '/common-service',
    //     name: 'common_service',
    //     component: () => import('@/layouts/CommonServiceLayout.vue'),
    //     meta: { auth: false },
    //     children: dashboardRoutes('common_service')
    // },
    {
        path: '/common-service/address-management',
        name: 'common_service.address_management',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: true },
        children: childRoutes('common_service.address_management')
    }
]

export default routes
