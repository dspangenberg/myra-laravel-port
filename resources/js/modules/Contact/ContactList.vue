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
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useContactStore } from '@/stores/ContactStore'
import ContactListItem from './ContactListItem.vue'
import {
  Table,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const contactStore = useContactStore()
const { contacts, meta, isLoading } = storeToRefs(contactStore)
const currentPage = ref(1)

const onSelect = async (id: number) => {
  await contactStore.findById(id)
  router.push({ name: 'contacts-details', params: { id } })
}

const onAddClicked = () => {
  contactStore.add()
  router.push({ name: 'users-add' })
}

watch(currentPage, async (page) => {
  await contactStore.getAll(page)
})

onMounted(async () => {
  await contactStore.getAll()
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>

<template>
  <TwiceUiPageLayout title="Accounts + Kontakte">
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
            <BreadcrumbPage>Accounts + Kontakte</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-toolbar>
      <ShdnUiButton @click="onAddClicked">
        Kontakt hinzufügen
      </ShdnUiButton>
    </template>
    <template #content-full>
      <twice-ui-table-box
        record-name="Kontakte"
        :record-count="contacts?.length"
        :loading="isLoading"
        :meta="meta"
        @update-page="onUpdatePage"
      >
        <Table>
          <TableBody>
            <ContactListItem
              v-for="(contact, index) in contacts"
              :key="index"
              :item="contact"
              @select="onSelect"
            />
          </TableBody>
        </Table>
      </twice-ui-table-box>
    </template>
  </TwiceUiPageLayout>
</template>
