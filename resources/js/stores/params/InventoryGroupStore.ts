import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllInventoryGroups, findInventoryGroupById, createInventoryGroup, updateInventoryGroup } from '@/api/params/InventoryGroup'
import { reactive, ref, type Ref } from 'vue'
import type { InventoryGroup } from '@/api/params/InventoryGroup'
import type { BusinessSegment } from '@/api/params/BusinessSegment'

import { type Meta } from '@/types/'

export const useInventoryGroupStore = defineStore('params-inventory-group', () => {
  const groups: Ref<InventoryGroup[] | null> = ref([])
  const segments: Ref<BusinessSegment[] | null> = ref([])
  const group: Ref<InventoryGroup | null> = ref(null)
  const groupEdit: Ref<InventoryGroup | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useInventoryGroupStore()

  const newRecordTemplate = reactive({
    name: '',
    inventory_number_prefix: '',
    inventory_current_number: 0
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta, segments: records } = await getAllInventoryGroups(page)
    store.$patch(state => {
      state.groups = data
      state.segments = records
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.group = newRecordTemplate
      state.groupEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { group: record } = await findInventoryGroupById(id)

    store.$patch(state => {
      state.group = record
      state.groupEdit = record
    })
  }

  const save = async (value: InventoryGroup) => {
    if (!value.id) {
      await createInventoryGroup(value)
    } else {
      await updateInventoryGroup(value)
    }
    groupEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    group,
    groupEdit,
    groups,
    meta,
    newRecordTemplate,
    segments,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useInventoryGroupStore, import.meta.hot))
}
