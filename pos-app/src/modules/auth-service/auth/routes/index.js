const authChildRoutes = (prop) => [
  {
    path: 'login',
    name: prop + '.login',
    meta: { auth: false, name: 'Editable' },
    component: () => import('../pages/Login.vue')
  },
  {
    path: 'sign-up',
    name: prop + '.sign_up',
    meta: { name: 'Editable' },
    component: () => import('../pages/SignUp.vue')
  },
  {
    path: 'forgot-password',
    name: prop + '.forgot_password',
    meta: { name: 'Editable' },
    component: () => import('../pages/ForgotPassword.vue')
  },
  {
    path: 'dashboard',
    name: prop + '.dashboard',
    meta: { auth: true, name: 'Editable' },
    props: true,
    component: () => import('../pages/Dashboard.vue')
  },
  {
    path: 'role-select',
    name: prop + '.role_select',
    meta: { auth: true, name: 'Editable' },
    props: true,
    component: () => import('../pages/RoleSelect.vue')
  }
]
const routes = [
  {
    path: '/auth',
    name: 'auth',
    component: () => import('@/layouts/AuthLayout.vue'),
    meta: { auth: true },
    children: authChildRoutes('auth')
  }
]

export default routes
