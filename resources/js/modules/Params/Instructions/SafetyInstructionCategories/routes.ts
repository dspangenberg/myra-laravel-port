const routes = {
  path: 'safety-categories',
  component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/index.vue'),
  children: [
    {
      path: '',
      name: 'params-instructions-safety-categories',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesList.vue')
    },
    {
      path: ':id/edit',
      name: 'params-instructions-safety-categories-edit',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesEdit.vue')
    },
    {
      path: 'add',
      name: 'params-instructions-safety-categories-add',
      component: () => import('@/modules/Params/Instructions/SafetyInstructionCategories/SafetyInstructionCategoriesEdit.vue')
    }
  ]
}
export default routes
