const routes = {
  path: 'empowerments',
  children: [
    {
      path: '',
      name: 'params-business-empowerments',
      component: () => import('@/modules/Params/Business/Empowerment/EmpowermentList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-business-empowerments-edit',
          component: () => import('@/modules/Params/Business/Empowerment/EmpowermentEdit.vue')
        },
        {
          path: 'add',
          name: 'params-business-empowerments-add',
          component: () => import('@/modules/Params/Business/Empowerment/EmpowermentEdit.vue')
        }
      ]
    }
  ]
}

export default routes
