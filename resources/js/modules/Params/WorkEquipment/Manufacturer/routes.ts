const routes = {
  path: 'manufacturers',
  children: [
    {
      path: '',
      name: 'params-work-equipment-manufacturers',
      component: () => import('@/modules/Params/WorkEquipment/Manufacturer/ManufacturerList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-work-equipment-manufacturers-edit',
          component: () => import('@/modules/Params/WorkEquipment/Manufacturer/ManufacturerEdit.vue')
        },
        {
          path: 'add',
          name: 'params-work-equipment-manufacturers-add',
          component: () => import('@/modules/Params/WorkEquipment/Manufacturer/ManufacturerEdit.vue')
        }
      ]
    }
  ]
}

export default routes
