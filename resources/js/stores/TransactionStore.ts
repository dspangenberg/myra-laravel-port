import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  getAllTransactions
} from '@/api/Transaction'
import { ref, type Ref } from 'vue'
import type { Transaction } from '@/api/Transaction'
import type { BankAccount } from '@/api/params/BankAccount'
import type { Meta } from '@/types'

export const useTransactionStore = defineStore('transaction-store', () => {
  const store = useTransactionStore()

  const transactions: Ref<Transaction[] | null> = ref([])
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  // eslint-disable-next-line camelcase
  const bank_accounts: Ref<BankAccount[] | null> = ref([])

  const getAll = async (params?: string) => {
    isLoading.value = true
    const data = await getAllTransactions(params || '')

    store.$patch(state => {
      state.transactions = data.data
      state.bank_accounts = data.bank_accounts
      state.meta = data.meta
    })
    isLoading.value = false
  }

  return {
    // eslint-disable-next-line camelcase
    bank_accounts,
    isLoading,
    meta,
    transactions,
    getAll
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useTransactionStore, import.meta.hot))
}
