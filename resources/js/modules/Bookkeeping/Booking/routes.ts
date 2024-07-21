const routes = {

  path: 'bookings',
  children: [
    {
      path: 'list',
      name: 'bookings-list',
      component: () => import('@/modules/Bookkeeping/Booking/BookingList.vue'),
      children: [
        {
          path: ':id',
          name: 'bookings-detail',
          component: () => import('@/modules/Bookkeeping/Booking/BookingDetails.vue')
        }
      ]
    }
  ]
}

export default routes
