const routes = {
  path: 'inventory-groups',
  children: [
    {
      path: '',
      name: 'params-work-equipment-inventory-groups',
      component: () => import('@/modules/Params/WorkEquipment/InventoryGroup/InventoryGroupList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-work-equipment-inventory-groups-edit',
          component: () => import('@/modules/Params/WorkEquipment/InventoryGroup/InventoryGroupEdit.vue')
        },
        {
          path: 'add',
          name: 'params-work-equipment-inventory-groups-add',
          component: () => import('@/modules/Params/WorkEquipment/InventoryGroup/InventoryGroupEdit.vue')
        }
      ]
    }
  ]
}

export default routes
