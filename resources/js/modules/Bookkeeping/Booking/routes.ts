const routes = {

  path: 'bookings',
  children: [
    {
      path: 'list',
      name: 'bookings-list',
      component: () => import('@/modules/Bookkeeping/Booking/BookingList.vue')
    }
  ]
}

export default routes
