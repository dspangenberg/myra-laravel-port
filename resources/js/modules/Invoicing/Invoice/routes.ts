const routes = {

  path: 'invoices',
  children: [
    {
      path: 'list',
      name: 'invoices-list',
      component: () => import('@/modules/Invoicing/Invoice/InvoiceList.vue'),
      children: [
      ]
    }
  ]
}

export default routes
