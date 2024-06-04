import DepartmentsRoutes from './Department/routes'
import FilingRoutes from './Filing/routes'
import StorageLocationRoutes from './StorageLocation/routes'
import SegmentsRoutes from './BusinessSegment/routes'
import EmpowermentRoutes from './Empowerment/routes'

const routes = {
  path: 'business',
  name: 'params-business',
  children: [
    DepartmentsRoutes,
    EmpowermentRoutes,
    FilingRoutes,
    SegmentsRoutes,
    StorageLocationRoutes
  ]
}

export default routes
