import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllProjects, findProjectById, createProject, updateProject } from '@/api/Project'
import { reactive, ref, type Ref } from 'vue'
import type { Project } from '@/api/Project'
import { type Meta } from '@/types/'

export const useProjectStore = defineStore('project-store', () => {
  const projects: Ref<Project[] | null> = ref([])
  const project: Ref<Project | null> = ref(null)
  const projectEdit: Ref<Project | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useProjectStore()

  const newRecordTemplate = reactive({
    id: 0,
    name: '',
    lead_user_id: 0,
    manager_contact_id: 0,
    owner_contact_id: 0,
    invoice_contact_id: 0,
    parent_project_id: 0,
    project_category_id: 0,
    is_archived: false,
    begin_on: '',
    end_on: '',
    website: '',
    note: '',
    hourly: 0,
    budget_hours: 0,
    budget_costs: 0,
    budget_period: 'y'
  })

  const getAll = async (qs: string = '') => {
    isLoading.value = true
    const { data, meta } = await getAllProjects(qs)
    store.$patch(state => {
      state.projects = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.project = newRecordTemplate
      state.projectEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { data } = await findProjectById(id)

    store.$patch(state => {
      state.project = data
      state.projectEdit = data
    })
  }

  const save = async (value: Project) => {
    if (!value.id) {
      await createProject(value)
    } else {
      await updateProject(value)
    }
    projectEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    project,
    projectEdit,
    projects,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useProjectStore, import.meta.hot))
}
