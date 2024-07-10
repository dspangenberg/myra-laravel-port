import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllReceipt, findReceiptById, createReceipt, updateReceipt } from '@/api/Receipt'
import { ref, type Ref } from 'vue'

import { type Meta } from '@/types/'
import type { Receipt } from '@/api/Receipt'

export const useReceiptStore = defineStore('receipt-store', () => {
  const receipts: Ref<Receipt[] | null> = ref([])
  const receipt: Ref<Receipt | null> = ref(null)
  const receiptEdit: Ref<Receipt | null> = ref(null)

  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useReceiptStore()

  const getAll = async (qs: string) => {
    isLoading.value = true
    const { data, meta } = await getAllReceipt(qs)
    store.$patch(state => {
      state.receipts = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const findById = async (id: number) => {
    const { data } = await findReceiptById(id)

    store.$patch(state => {
      state.receipt = data
      state.receiptEdit = data
    })
  }

  const save = async (value: Receipt, refreshData: boolean = true) => {
    if (!value.id) {
      await createReceipt(value)
    } else {
      await updateReceipt(value)
    }
    receiptEdit.value = null

    if (refreshData) {
      await getAll('')
    }
  }

  return {
    isLoading,
    receipt,
    receiptEdit,
    receipts,
    meta,

    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useReceiptStore, import.meta.hot))
}
