const routes = {

  path: 'projects',
  children: [
    {
      path: '',
      name: 'projects-list',
      component: () => import('@/modules/Project/ProjectList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'projects-edit',
          component: () => import('@/modules/Project/ProjectEdit.vue')
        },
        {
          path: 'add',
          name: 'projects-add',
          component: () => import('@/modules/Project/ProjectEdit.vue')
        }
      ]
    }
  ]
}

export default routes
