import Manufacturer from './Manufacturer/routes'
import InventoryGroup from './InventoryGroup/routes'
import EqquipmentCategory from './EquipmentCategory/routes'

const routes = {
  path: 'work-eqquipment',
  children: [
    Manufacturer,
    InventoryGroup,
    EqquipmentCategory
  ]
}

export default routes
