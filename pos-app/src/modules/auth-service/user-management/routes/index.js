const childRoutes = (prop) => [
    {
      path: 'assign-user-list',
      name: prop + '.assign_user_list',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/user-role/List.vue')
    },
    {
      path: 'assign-user-form',
      name: prop + '.assign_user_form',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/user-role/Form.vue')
    },
    {
      path: 'menu-privilege-list',
      name: prop + '.menu_privilege_list',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/menu-privilege/List.vue')
    },
    {
      path: 'menu-privilege',
      name: prop + '.menu_privilege',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/menu-privilege/MenuPrivilege.vue')
    },
    {
      path: 'role',
      name: prop + '.role',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/role/List.vue')
    },
    {
      path: 'user-list',
      name: prop + '.user_list',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/user/List.vue')
    },
    {
      path: 'secret-question',
      name: prop + '.secret_question',
      meta: { auth: true, name: 'Editable' },
      component: () => import('../pages/secret-question/List.vue')
    }
]

const routes = [
    {
      path: '/auth-service/user-management',
      name: 'auth_service.user_management',
      component: () => import('@/layouts/CommonServiceLayout.vue'),
      meta: { auth: false },
      children: childRoutes('auth_service.user_management')
    }
]

export default routes
