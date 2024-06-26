const routes = {

  path: 'contacts',
  children: [
    {
      path: '',
      name: 'contacts-list',
      component: () => import('@/modules/Contact/ContactList.vue'),
      children: [
        {
          path: 'add',
          name: 'contacts-add',
          component: () => import('@/modules/Contact/ContactAdd.vue')
        }
      ]
    },
    {
      path: ':id',
      name: 'contacts-details',
      component: () => import('@/modules/Contact/ContactDetails.vue'),
      children: [
        {
          path: 'add',
          name: 'contacts-person-add',
          component: () => import('@/modules/Contact/ContactAddPerson.vue')
        },
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
