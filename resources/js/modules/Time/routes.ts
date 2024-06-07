const routes = {
  path: 'times',
  children: [
    {
      path: ':type',
      name: 'times-list',
      component: () => import('@/modules/Time/TimeList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'times-edit',
          component: () => import('@/modules/Time/TimeEdit.vue')
        },
        {
          path: 'add',
          name: 'times-add',
          component: () => import('@/modules/Time/TimeEdit.vue')
        }
      ]
    }
  ]
}

export default routes
