const routes = {
  path: 'departments',
  children: [
    {
      path: '',
      name: 'params-business-departments',
      component: () => import('@/modules/Params/Business/Department/DepartmentList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-business-departments-edit',
          component: () => import('@/modules/Params/Business/Department/DepartmentEdit.vue')
        },
        {
          path: 'add',
          name: 'params-business-departments-add',
          component: () => import('@/modules/Params/Business/Department/DepartmentEdit.vue')
        }
      ]
    }
  ]
}

export default routes
