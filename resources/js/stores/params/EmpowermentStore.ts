import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllEmpowerments, findEmpowermentById, createEmpowerment, updateEmpowerment } from '@/api/params/Empowerment'
import { reactive, ref, type Ref } from 'vue'
import type { Empowerment } from '@/api/params/Empowerment'
import { type Meta } from '@/types/'

export const useEmpowermentStore = defineStore('params-empowerment-store', () => {
  const empowerments: Ref<Empowerment[] | null> = ref([])
  const empowerment: Ref<Empowerment | null> = ref(null)
  const empowermentEdit: Ref<Empowerment | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useEmpowermentStore()

  const newRecordTemplate = reactive({
    name: '',
    abbreviation: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllEmpowerments(page)
    store.$patch(state => {
      state.empowerments = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.empowerment = newRecordTemplate
      state.empowermentEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { empowerment: record } = await findEmpowermentById(id)

    store.$patch(state => {
      state.empowerment = record
      state.empowermentEdit = record
    })
  }

  const save = async (value: Empowerment) => {
    if (!value.id) {
      await createEmpowerment(value)
    } else {
      await updateEmpowerment(value)
    }
    empowermentEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    empowerment,
    empowermentEdit,
    empowerments,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useEmpowermentStore, import.meta.hot))
}
