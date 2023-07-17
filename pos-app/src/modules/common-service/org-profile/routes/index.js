const childRoutes = (prop) => [
    {
      path: 'country',
      name: prop + '.country',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/country/List.vue')
    },
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
      path: 'union',
      name: prop + '.union',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/union/List.vue')
    },
    {
      path: 'organization-profile',
      name: prop + '.organization-profile',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/organization-profile/List.vue')
    },
    {
      path: 'city-corporation',
      name: prop + '.city_corporation',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/city-corporation/List.vue')
    },
    {
      path: 'municipality',
      name: prop + '.municipality',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/municipality/List.vue')
    },
    {
      path: 'ward',
      name: prop + '.ward',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/ward/List.vue')
    },
    {
      path: 'fiscalyear',
      name: prop + '.fiscalyear',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/fiscalyear/List.vue')
    },
    {
      path: 'bank',
      name: prop + '.bank',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/bank/List.vue')
    },
    {
      path: 'dialogue-info',
      name: prop + '.dialogue-info',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/dialogue-info/List.vue')
    },
    {
      path: 'branch',
      name: prop + '.branch',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/branch/List.vue')
    }
]

const routes = [
    {
        path: '/common-service/org-profile',
        name: 'common_service.org_profile',
        component: () => import('@/layouts/CommonServiceLayout.vue'),
        meta: { auth: false },
        children: childRoutes('common_service.org_profile')
    }
]

export default routes
