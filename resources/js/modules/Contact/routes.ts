const routes = {

  path: 'contacts',
  children: [
    {
      path: '',
      name: 'contacts-list',
      component: () => import('@/modules/Contact/ContactList.vue')
    },
    {
      path: 'add',
      name: 'contacts-add',
      component: () => import('@/modules/Contact/ContactEdit.vue')
    },
    {
      path: ':id',
      name: 'contacts-details',
      component: () => import('@/modules/Contact/ContactDetails.vue'),
      children: [
        {
          path: 'edit',
          name: 'contacts-edit',
          component: () => import('@/modules/Contact/ContactEdit.vue')
        }
      ]
    }
  ]
}

export default routes
