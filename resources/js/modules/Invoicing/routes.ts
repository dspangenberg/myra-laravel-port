import invoiceRoutes from '@/modules/Invoicing/Invoice/routes'

const routes = {
  path: 'invoicing',
  children: [
    invoiceRoutes
  ]
}

export default routes
