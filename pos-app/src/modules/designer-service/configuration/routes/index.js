const childRoutes = (prop) => [
  {
    path: 'template-one',
    name: prop + 'template_one',
    meta: { auth: true, name: 'Editable' },
    component: () => import('../pages/template-one/List.vue')
  },
  {
    path: 'template-two',
    name: prop + 'template_two',
    meta: { auth: true, name: 'Editable' },
    component: () => import('../pages/template-two/List.vue')
  },
  {
    path: 'dashboard',
    name: prop + 'dashboard',
    meta: { auth: true, name: 'Editable' },
    component: () => import('../pages/Dashboard.vue')
  }
]
const routes = [
  {
    path: '/designer-service/configuration',
    name: 'designer_service.configuration',
    component: () => import('@/layouts/DesignerLayout.vue'),
    // meta: { auth: true },
    children: childRoutes('designer_service.configuration')
  }
]

export default routes
