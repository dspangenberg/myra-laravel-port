import { defineStore, acceptHMRUpdate } from 'pinia'
import { createManufacturer, getAllManufacturer, updateManufacturer, findManufacturerById } from '@/api/params/Manufacturer'
import { reactive, ref, type Ref } from 'vue'
import type { Manufacturer } from '@/api/params/Manufacturer'
import { type Meta } from '@/types/'

export const useManufacturerStore = defineStore('params-manufacturers', () => {
  const manufacturers: Ref<Manufacturer[] | null> = ref([])
  const manufacturer: Ref<Manufacturer | null> = ref(null)
  const manufacturerEdit: Ref<Manufacturer | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useManufacturerStore()

  const newRecordTemplate = reactive({
    name: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllManufacturer(page)
    store.$patch(state => {
      state.manufacturers = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.manufacturer = newRecordTemplate
      state.manufacturerEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { manufacturer: apiManufacturer } = await findManufacturerById(id)

    store.$patch(state => {
      state.manufacturer = apiManufacturer
      state.manufacturerEdit = apiManufacturer
    })
  }

  const save = async (value: Manufacturer) => {
    if (!value.id) {
      await createManufacturer(value)
    } else {
      await updateManufacturer(value)
    }
    manufacturerEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    manufacturer,
    manufacturerEdit,
    manufacturers,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useManufacturerStore, import.meta.hot))
}
