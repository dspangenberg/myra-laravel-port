const routes = {

  path: 'receipts',
  children: [
    {
      path: 'list',
      name: 'receipts-list',
      component: () => import('@/modules/Invoicing/Receipt/ReceiptList.vue'),
      children: [
        {
          path: ':id',
          name: 'receipts-detail',
          component: () => import('@/modules/Invoicing/Receipt/ReceiptDetails.vue')
        }
      ]
    },
    {
      path: 'grouped',
      name: 'receipts-grouped-list',
      component: () => import('@/modules/Invoicing/Receipt/ReceiptGroupedList.vue')
    }
  ]
}

export default routes
