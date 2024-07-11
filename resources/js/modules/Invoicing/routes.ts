import receiptRoutes from '@/modules/Invoicing/Receipt/routes'

const routes = {
  path: 'invoicing',
  children: [
    receiptRoutes
  ]
}

export default routes
