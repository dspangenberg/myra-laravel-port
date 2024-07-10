const routes = {

  path: 'receipts',
  children: [
    {
      path: '',
      name: 'receipts-list',
      component: () => import('@/modules/Receipt/ReceiptList.vue'),
      children: [
        {
          path: ':id',
          name: 'receipts-detail',
          component: () => import('@/modules/Receipt/ReceiptDetails.vue')
        }
      ]
    }
  ]
}

export default routes
