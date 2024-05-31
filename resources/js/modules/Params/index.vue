<script setup lang="ts">
import { ref, watch } from 'vue'
import { useParamsLayoutStore } from '@/stores/ParamsLayoutStore'
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'

import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'

const paramsLayoutStore = useParamsLayoutStore()

const route = useRoute()
const router = useRouter()
const paramsItem = ref()
const paramsSubItem = ref()

const { navigation } = storeToRefs(paramsLayoutStore)

const onAddClicked = () => {
  router.push({ name: paramsSubItem.value.addButtonRoute })
}

watch(route, (route) => {
  const { item, subItem } = paramsLayoutStore.getActiveItem(route.path)
  paramsItem.value = item
  paramsSubItem.value = subItem
}, { immediate: true })

</script>

<template>
  <twice-ui-page-layout :title="paramsSubItem?.title">
    <template #breadcrumbs>
      <Breadcrumb>
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/">
              Dashboard
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/params/business/segments">
              Parameterdaten
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator v-if="paramsItem" />
          <BreadcrumbItem v-if="paramsItem">
            <BreadcrumbPage>{{ paramsItem?.label }}</BreadcrumbPage>
          </BreadcrumbItem>
          <BreadcrumbSeparator v-if="paramsSubItem" />
          <BreadcrumbItem v-if="paramsSubItem ">
            <BreadcrumbPage>{{ paramsSubItem?.title }}</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-toolbar>
      <shdn-ui-button
        v-if="paramsSubItem"
        @click="onAddClicked"
      >
        {{ paramsSubItem?.addButtonTitle }} hinzufügen
      </shdn-ui-button>
    </template>
    <template #content-full>
      <div class="grid grid-cols-5 gap-6">
        <div class="col-span-1 mt-6">
          <twice-ui-nav-item
            v-for="(item, index) in navigation"
            :key="index"
            :disabled="item.disabled"
            :label="item.label"
            :icon="item.icon"
            :route-name="item.route || ''"
            :active-route-path="item.activeRoute"
          >
            <twice-ui-sub-nav-item
              v-for="(subItem, subIndex) in item.items"
              :key="subIndex"
              :seperator="subItem.seperator || false"
              :disabled="subItem.disabled"
              :label="subItem.label"
              :route-name="subItem.route"
              :active-route-path="subItem.activeRoute"
            />
          </twice-ui-nav-item>
        </div>
        <div class="col-span-4 pr-0.5">
          <router-view />
        </div>
      </div>
    </template>
  </twice-ui-page-layout>
</template>
