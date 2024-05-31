import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllEquipmentCategories, findEquipmentCategoryById, createEquipmentCategory, updateEquipmentCategory } from '@/api/params/EquipmentCategory'
import { reactive, ref, type Ref } from 'vue'
import type { EquipmentCategory } from '@/api/params/EquipmentCategory'
import type { InventoryGroup } from '@/api/params/InventoryGroup'

import { type Meta } from '@/types/'

export const useEquipmentCategoryStore = defineStore('params-equipment-category', () => {
  const categories: Ref<EquipmentCategory[] | null> = ref([])
  const category: Ref<EquipmentCategory | null> = ref(null)
  const categoryEdit: Ref<EquipmentCategory | null> = ref(null)
  const parentCategories: Ref<EquipmentCategory[] | null> = ref([])
  const groups: Ref<InventoryGroup[] | null> = ref([])

  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useEquipmentCategoryStore()

  const newRecordTemplate = reactive({
    name: '',
    parent_id: 0,
    eqquipment_group_id: 0,
    inventory_groups: []
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    // eslint-disable-next-line camelcase
    const { data, meta, parent_categories: record, groups: apiGroups } = await getAllEquipmentCategories(page)
    store.$patch(state => {
      state.categories = data
      state.meta = meta
      state.parentCategories = record
      state.groups = apiGroups
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.category = newRecordTemplate
      state.categoryEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { data } = await findEquipmentCategoryById(id)

    store.$patch(state => {
      state.category = data
      state.categoryEdit = data
    })
  }

  const save = async (value: EquipmentCategory) => {
    if (!value.id) {
      await createEquipmentCategory(value)
    } else {
      await updateEquipmentCategory(value)
    }
    categoryEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    category,
    categoryEdit,
    categories,
    groups,
    parentCategories,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useEquipmentCategoryStore, import.meta.hot))
}
