const routes = {
  path: 'categories',
  children: [
    {
      path: '',
      name: 'params-work-equipment-categories',
      component: () => import('@/modules/Params/WorkEquipment/EquipmentCategory/EquipmentCategoryList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-work-equipment-categories-edit',
          component: () => import('@/modules/Params/WorkEquipment/EquipmentCategory/EquipmentCategoryEdit.vue')
        },
        {
          path: 'add',
          name: 'params-work-equipment-categories-add',
          component: () => import('@/modules/Params/WorkEquipment/EquipmentCategory/EquipmentCategoryEdit.vue')
        }
      ]
    }
  ]
}

export default routes
