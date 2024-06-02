<script setup lang="ts">
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'

import { storeToRefs } from 'pinia'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/UserStore'
import UserListItem from './UserListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const userStore = useUserStore()
const { users, meta, isLoading } = storeToRefs(userStore)

const onSelect = async (id: number) => {
  await userStore.findById(id)
  router.push({ name: 'users-edit', params: { id } })
}

const onAddClicked = () => {
  userStore.add()
  router.push({ name: 'users-add' })
}

onMounted(async () => {
  await userStore.getAll()
})

const currentPage = ref(1)

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>

<template>
  <twice-ui-page-layout title="Benutzer*innen">
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
            <BreadcrumbPage>Benutzer*innen</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-toolbar>
      <shdn-ui-button @click="onAddClicked">
        Benutzer*in hinzufügen
      </shdn-ui-button>
    </template>
    <template #content-full>
      <div class="px-0.5">
        <twice-ui-table-box
          v-if="meta"
          :meta="meta"
          record-name="Benutzer*innen"
          :loading="isLoading"
          @update-page="onUpdatePage"
        >
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead class="w-12" />
                <TableHead class="w-96">
                  Name
                </TableHead>
                <TableHead class="w-auto">
                  E-Mail
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <UserListItem
                v-for="(user, index) in users"
                :key="index"
                :item="user"
                @select="onSelect"
              />
            </TableBody>
          </Table>
        </twice-ui-table-box>
      </div>
      <router-view />
    </template>
  </twice-ui-page-layout>
</template>
