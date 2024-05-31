const routes = {
  path: 'storage-locations',
  children: [
    {
      path: '',
      name: 'params-business-storage-locations',
      component: () => import('@/modules/Params/Business/StorageLocation/StorageLocationList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-business-storage-locations-edit',
          component: () => import('@/modules/Params/Business/StorageLocation/StorageLocationEdit.vue')
        },
        {
          path: 'add',
          name: 'params-business-storage-locations-add',
          component: () => import('@/modules/Params/Business/StorageLocation/StorageLocationEdit.vue')
        }
      ]
    }
  ]
}

export default routes
