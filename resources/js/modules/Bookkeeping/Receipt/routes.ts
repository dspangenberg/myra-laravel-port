const routes = {

  path: 'receipts',
  children: [
    {
      path: 'list',
      name: 'receipts-list',
      component: () => import('@/modules/Bookkeeping/Receipt/ReceiptList.vue')
    },
    {
      path: 'grouped',
      name: 'receipts-grouped-list',
      component: () => import('@/modules/Bookkeeping/Receipt/ReceiptGroupedList.vue')
    }
  ]
}

export default routes
