import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  getAllDocuments
} from '@/api/Document'
import { ref, type Ref } from 'vue'
import type { Document } from '@/api/Document'
import type { Meta } from '@/types'

export const useDocumentStore = defineStore('document-store', () => {
  const store = useDocumentStore()

  const documents: Ref<Document[] | null> = ref([])
  const document: Ref<Document | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)
  const meta: Ref<Meta | null> = ref(null)

  const getAll = async (params?: string) => {
    isLoading.value = true
    const data = await getAllDocuments(params)

    store.$patch(state => {
      state.documents = data.data
      state.meta = data.meta
    })
    isLoading.value = false
  }

  return {
    document,
    documents,
    isLoading,
    meta,
    getAll
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useDocumentStore, import.meta.hot))
}
