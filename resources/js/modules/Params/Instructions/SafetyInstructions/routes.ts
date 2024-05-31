const routes = {

  path: 'safety-instructions',
  name: 'safety-instructions',
  component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/index.vue'),
  children: [
    {
      path: '',
      name: 'safety-instructions-list',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesList.vue')
    },
    {
      path: ':id/edit',
      name: 'safety-instructions-edit',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesEdit.vue')
    },
    {
      path: 'add',
      name: 'safety-instructions-add',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesEdit.vue')
    }
  ]
}

export default routes
