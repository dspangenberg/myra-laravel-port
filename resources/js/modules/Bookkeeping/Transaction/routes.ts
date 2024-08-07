const routes = {

  path: 'transactions',
  children: [
    {
      path: 'list',
      name: 'transactions-list',
      component: () => import('@/modules/Bookkeeping/Transaction/TransactionList.vue')
    }
  ]
}

export default routes
