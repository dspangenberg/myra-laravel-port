import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllDepartments, findDepartmentById, createDepartment, updateDepartment } from '@/api/params/Department'
import { reactive, ref, type Ref } from 'vue'
import type { Department } from '@/api/params/Department'
import { type Meta } from '@/types/'

export const useDepartmentStore = defineStore('params-department-store', () => {
  const departments: Ref<Department[] | null> = ref([])
  const department: Ref<Department | null> = ref(null)
  const departmentEdit: Ref<Department | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useDepartmentStore()

  const newRecordTemplate = reactive({
    name: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllDepartments(page)
    store.$patch(state => {
      state.departments = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.department = newRecordTemplate
      state.departmentEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { department: record } = await findDepartmentById(id)

    store.$patch(state => {
      state.department = record
      state.departmentEdit = record
    })
  }

  const save = async (value: Department) => {
    if (!value.id) {
      await createDepartment(value)
    } else {
      await updateDepartment(value)
    }
    departmentEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    department,
    departmentEdit,
    departments,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useDepartmentStore, import.meta.hot))
}
