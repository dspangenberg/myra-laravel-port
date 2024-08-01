import { createRouter, createWebHistory } from 'vue-router'
import { useGlobalStore } from '@/stores/GlobalStore'
import userRoutes from '@/modules/User/routes'
import contactRoutes from '@/modules/Contact/routes'
import projectRoutes from '@/modules/Project/routes'
import timeRoutes from '@/modules/Time/routes'
import bookKeepingRoutes from '@/modules/Bookkeeping/routes'
import invoicingRoutes from '@/modules/Invoicing/routes'
import documentesRoutes from '@/modules/Document/routes'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      redirect: () => {
        return { name: 'dashboard' }
      }
    },
    {
      path: '/forbidden',
      name: 'forbidden',
      meta: { requiresAuth: false },
      component: () => import('@/views/Forbidden.vue')
    },
    {
      path: '/auth',
      name: 'authLayout',
      meta: { requiresAuth: false },
      component: () => import('@/layouts/AuthLayout.vue'),
      children: [
        {
          path: 'login',
          name: 'login',
          component: () => import('@/views/Login.vue')
        },
        {
          path: 'logout',
          name: 'logout',
          component: () => import('@/views/Logout.vue')
        }
      ]
    },
    {
      path: '/app',
      meta: { requiresAuth: true },
      component: () => import('@/layouts/AppLayout.vue'),
      children: [
        {
          path: '',
          name: 'dashboard',
          component: () => import('@/modules/Dashboard/index.vue')
        },
        {
          path: 'agenda',
          name: 'agenda',
          component: () => import('@/views/Soon.vue')
        },
        {
          path: 'documents',
          component: () => import('@/views/Soon.vue')
        },
        invoicingRoutes,
        bookKeepingRoutes,
        contactRoutes,
        documentesRoutes,
        projectRoutes,
        timeRoutes,
        userRoutes
      ]
    },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import('@/views/NotFound.vue') }
  ]
})

router.beforeEach((to, from, next) => {
  const globalStore = useGlobalStore()

  router.onError(handler => console.log(handler, from, to))

  if (globalStore.isAuthenticated || to.meta.requiresAuth === false) {
    next()
  } else {
    next({ name: 'login' })
  }
})

export default router
