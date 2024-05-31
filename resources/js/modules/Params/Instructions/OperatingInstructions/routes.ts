const routes = {
  path: 'operating-instructions',
  children: [
    {
      path: '',
      name: 'params-instructions-operating-instructions',
      component: () => import('@/modules/Params/Instructions/OperatingInstructions/OperatingInstructionsList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-instructions-operating-instructions-edit',
          component: () => import('@/modules/Params/Instructions/OperatingInstructions/OperatingInstructionsEdit.vue')
        },
        {
          path: 'add',
          name: 'params-instructions-operating-instructions-add',
          component: () => import('@/modules/Params/Instructions/OperatingInstructions/OperatingInstructionsEdit.vue')
        }
      ]
    }
  ]
}

export default routes
