const routes = {

  path: 'documents',
  children: [
    {
      path: 'list',
      name: 'documents-list',
      component: () => import('@/modules/Document/DocumentList.vue'),
      children: [
      ]
    }
  ]
}

export default routes
