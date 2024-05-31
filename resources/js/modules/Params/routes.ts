import ParamsInstructionsRoutes from './Instructions/routes'
import ParamsBusinessRoutes from './Business/routes'
import ParamsWorkEquipment from './WorkEquipment/routes'

const routes = {
  path: 'params',
  name: 'params',
  component: () => import('@/modules/Params/index.vue'),
  children: [
    ParamsInstructionsRoutes,
    ParamsBusinessRoutes,
    ParamsWorkEquipment
  ]
}

export default routes
