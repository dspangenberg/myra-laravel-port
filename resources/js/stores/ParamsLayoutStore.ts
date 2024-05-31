import { defineStore, acceptHMRUpdate } from 'pinia'
import { ref, type Ref } from 'vue'
import type { ParamsLayoutNavigationItem, ParamsLayoutNavigationSubItem } from '@/types/'
import json from '@/layouts/params.json'

interface ActiveItem {
  item: ParamsLayoutNavigationItem | null
  subItem: ParamsLayoutNavigationSubItem | null
}

export const useParamsLayoutStore = defineStore('params-layout-store', () => {
  const navigation: Ref<ParamsLayoutNavigationItem[]> = ref(json)

  const getActiveItem = (url: string): ActiveItem => {
    const [itemName, subItemName] = url.replace('/app/params/', '').split('/')
    const item = navigation.value.find(item => item.name === itemName)
    if (item) {
      const subItem = item.items.find(item => item.name === subItemName)
      if (subItem) {
        return { item, subItem }
      }
    }

    return { item: null, subItem: null }
  }

  return {
    getActiveItem,
    navigation
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useParamsLayoutStore, import.meta.hot))
}
