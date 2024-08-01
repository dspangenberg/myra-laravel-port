import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  createInvoicePdf,
  getAllInvoices
} from '@/api/Invoice'
import { ref, type Ref } from 'vue'
import type { Invoice } from '@/api/Invoice'
import type { Meta } from '@/types'

export const useInvoiceStore = defineStore('invoice-store', () => {
  const store = useInvoiceStore()

  const invoices: Ref<Invoice[] | null> = ref([])
  const isLoading: Ref<boolean> = ref(false)
  const invoice: Ref<Invoice | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)

  const getAll = async (params?: string) => {
    isLoading.value = true
    const data = await getAllInvoices(params)

    store.$patch(state => {
      state.invoices = data.data
      state.meta = data.meta
    })
    isLoading.value = false
  }

  const createPdf = async (id: number) => {
    return await createInvoicePdf(id)
  }

  return {
    invoice,
    invoices,
    isLoading,
    meta,
    createPdf,
    getAll
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useInvoiceStore, import.meta.hot))
}
