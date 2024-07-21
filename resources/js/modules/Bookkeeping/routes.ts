import receiptRoutes from '@/modules/Bookkeeping/Receipt/routes'
import bookingtRoutes from '@/modules/Bookkeeping/Booking/routes'

const routes = {
  path: 'bookkeeping',
  children: [
    bookingtRoutes,
    receiptRoutes
  ]
}

export default routes
