import receiptRoutes from '@/modules/Bookkeeping/Receipt/routes'
import bookingtRoutes from '@/modules/Bookkeeping/Booking/routes'
import transactionRoutes from '@/modules/Bookkeeping/Transaction/routes'

const routes = {
  path: 'bookkeeping',
  children: [
    bookingtRoutes,
    receiptRoutes,
    transactionRoutes
  ]
}

export default routes
