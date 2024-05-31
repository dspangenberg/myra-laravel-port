const routes = {
  path: 'segments',
  children: [
    {
      path: '',
      name: 'params-business-segments',
      component: () => import('@/modules/Params/Business/BusinessSegment/BusinessSegmentList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-business-segments-edit',
          component: () => import('@/modules/Params/Business/BusinessSegment/BusinessSegmentEdit.vue')
        },
        {
          path: 'add',
          name: 'params-business-segments-add',
          component: () => import('@/modules/Params/Business/BusinessSegment/BusinessSegmentEdit.vue')
        }
      ]
    }
  ]
}

export default routes
