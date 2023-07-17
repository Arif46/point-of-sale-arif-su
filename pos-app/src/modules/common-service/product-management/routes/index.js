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
      path: 'category',
      name: prop + '.category',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/category/List.vue')
    },
    {
      path: 'brand',
      name: prop + '.brand',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/brand/List.vue')
    },
    {
      path: 'color',
      name: prop + '.color',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/color/List.vue')
    },
    {
      path: 'model',
      name: prop + '.model',
      meta: { auth: true, name: 'model' },
      component: () => import('../pages/model/List.vue')
    },
    {
      path: 'size',
      name: prop + '.size',
      meta: { auth: true, name: 'size' },
      component: () => import('../pages/size/List.vue')
    },
    {
      path: 'weight',
      name: prop + '.weight',
      meta: { auth: true, name: 'weight' },
      component: () => import('../pages/weight/List.vue')
    },
    {
      path: 'product',
      name: prop + '.product',
      meta: { auth: true, name: 'product' },
      component: () => import('../pages/product/List.vue')
    }
]

const routes = [
    {
        path: '/common-service/product-management',
        name: 'common_service.product_management',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: true },
        children: childRoutes('common_service.product_management')
    }
]

export default routes
