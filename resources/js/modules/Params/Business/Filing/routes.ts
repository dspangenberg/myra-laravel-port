const routes = {
  path: 'filings',
  children: [
    {
      path: '',
      name: 'params-business-filings',
      component: () => import('@/modules/Params/Business/Filing/FilingList.vue'),
      children: [
        {
          path: ':id/edit',
          name: 'params-business-filings-edit',
          component: () => import('@/modules/Params/Business/Filing/FilingEdit.vue')
        },
        {
          path: 'add',
          name: 'params-business-filings-add',
          component: () => import('@/modules/Params/Business/Filing/FilingEdit.vue')
        }
      ]
    }
  ]
}

export default routes
