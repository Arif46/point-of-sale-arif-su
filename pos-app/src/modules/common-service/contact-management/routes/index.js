
const childRoutes = (prop) => [
    {
      path: 'shop',
      name: prop + '.shop',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/shop/List.vue')
    }
]

const routes = [
    {
        path: '/common-service/contact-management',
        name: 'common_service.contact_management',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: true },
        children: childRoutes('common_service.contact_management')
    }
]

export default routes
