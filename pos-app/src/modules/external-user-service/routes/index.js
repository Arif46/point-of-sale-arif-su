// cip panel child routes
const cipPanelRoute = prop => [
  {
    path: 'dashboard',
    name: prop + '.dashboard',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/Dashboard.vue')
  },
  {
    path: 'circular',
    name: prop + '.circular',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/circular/List.vue')
  },
  {
    path: 'cip-application',
    name: prop + '.cip_application',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/cip-application/List.vue')
  },
  {
    path: 'cip-application-form',
    name: prop + '.cip_application_form',
    meta: { auth: true },
    props: true,
    component: () => import('../views/export-trophy-cip-panel/pages/cip-application/Form.vue')
  },
  {
    path: 'export-trophy-application',
    name: prop + '.export_trophy_application',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/export-tophy-application/List.vue')
  },
  {
    path: 'export-trophy-application-form',
    name: prop + '.export_trophy_application_form',
    meta: { auth: true },
    props: true,
    component: () => import('../views/export-trophy-cip-panel/pages/export-tophy-application/Form.vue')
  },
  {
    path: 'gazettes',
    name: prop + '.gazettes',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/gazettes/List.vue')
  },
  {
    path: 'cip-award-invitation',
    name: prop + '.cip_award_invitation',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/cip-award-invitation/List.vue')
  },
  {
    path: 'export-trophy-award-invitation',
    name: prop + '.export_trophy_award_invitation',
    meta: { auth: true },
    component: () => import('../views/export-trophy-cip-panel/pages/export-trophy-award-invitation/List.vue')
  }
]
const bftiPanelRoute = prop => [
  {
    path: 'dashboard',
    name: prop + '.dashboard',
    meta: { auth: true },
    component: () => import('../views/bfti-panel/pages/Dashboard.vue')
  },
  {
    path: 'research-and-other-request-list',
    name: prop + '.research-and-other-request-list',
    meta: { auth: true },
    component: () => import('../views/bfti-panel/pages/research-and-other-request/List')
  },
  {
    path: 'policy-request-entry',
    name: prop + '.policy-request-entry',
    meta: { auth: true },
    component: () => import('../views/bfti-panel/pages/policy-request-entry/List')
  },
  {
    path: 'receive-meeting-notice',
    name: prop + '.receive_meeting_notice',
    meta: { auth: true },
    component: () => import('../views/bfti-panel/pages/receive-meeting-notice/List')
  }
]
const dealerPanelRoute = prop => [
  {
    path: 'dashboard',
    name: prop + '.dashboard',
    meta: { auth: true },
    component: () => import('../views/dealer-panel/pages/Dashboard.vue')
  },
  {
    path: 'applications',
    name: prop + '.application',
    meta: { auth: true },
    component: () => import('../views/dealer-panel/pages/application/List')
  },
  {
    path: 'allocation-letter',
    name: prop + '.allocation-letter',
    meta: { auth: true },
    component: () => import('../views/dealer-panel/pages/allocation-letter/List')
  },
  {
    path: 'complain',
    name: prop + '.complain',
    meta: { auth: true },
    component: () => import('../views/dealer-panel/pages/complain/List')
  },
  {
    path: 'faq',
    name: prop + '.faq',
    meta: { auth: true },
    component: () => import('../views/dealer-panel/pages/faq/List')
  }
]

// common profile routes
const commonProfileRoute = prop => [
  {
    path: 'profile',
    name: prop + '.profile',
    meta: { auth: true },
    component: () => import('../views/ProfileShow.vue')
  },
  {
    path: 'profile-update',
    name: prop + '.profile_update',
    meta: { auth: true },
    component: () => import('../views/ProfileUpdate.vue')
  },
  {
    path: 'panel',
    name: prop + '.panel',
    meta: { auth: true },
    component: () => import('../views/Panel.vue')
  }
]

const routes = [
  {
    path: '/export-trophy-cip-panel',
    name: 'export_trophy_cip_panel',
    component: () => import('@/layouts/ExternalUser/CipPanelLayout.vue'),
    meta: { auth: true },
    children: cipPanelRoute('export_trophy_cip_panel')
  },
  {
    path: '/external-user',
    name: 'external_user',
    component: () => import('@/layouts/ExternalUser/CipPanelLayout.vue'),
    meta: { auth: true },
    children: commonProfileRoute('external_user')
  },
  {
    path: '/bfti-panel',
    name: 'bfti_panel',
    component: () => import('@/layouts/ExternalUser/BftiPanelLayout.vue'),
    meta: { auth: true },
    children: bftiPanelRoute('bfti_panel')
  },
  {
    path: '/dealer-panel',
    name: 'dealer_panel',
    component: () => import('@/layouts/ExternalUser/DealerPanelLayout.vue'),
    meta: { auth: true },
    children: dealerPanelRoute('dealer_panel')
  }
]

export default routes
