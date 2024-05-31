const routes = {

  path: 'users',
  children: [
    {
      path: '',
      name: 'users-list',
      component: () => import('@/modules/User/UserList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'users-edit',
          component: () => import('@/modules/User/UserEdit.vue')
        },
        {
          path: 'add',
          name: 'users-add',
          component: () => import('@/modules/User/UserEdit.vue')
        }
      ]
    }
  ]
}

export default routes
