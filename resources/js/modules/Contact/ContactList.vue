<script lang="ts" setup>
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import { useLaravelQuery } from '@/composables/useLaravelQuery'

import { storeToRefs } from 'pinia'
import { computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useContactStore } from '@/stores/ContactStore'
import ContactListItem from './ContactListItem.vue'
import {
  Table,
  TableBody
} from '@/components/shdn/ui/table'
import { IconCircleDashedPlus } from '@tabler/icons-vue'
const route = useRoute()
const router = useRouter()
const contactStore = useContactStore()
const { contacts, meta, isLoading } = storeToRefs(contactStore)
const qs = computed(() => route.query)

const { queryString } = useLaravelQuery(['page'])

const onSelect = async (id: number) => {
  await contactStore.findById(id)
  router.push({ name: 'contacts-details', params: { id } })
}

const onAddClicked = async () => {
  await contactStore.createOrEdit()
  router.push({ name: 'contacts-add', query: route.query })
}

watch(qs, async () => {
  if (route.name === 'contacts-list') {
    await contactStore.getAll(queryString.value)
  }
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
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
      <ShdnUiButton
        size="icon"
        variant="ghost"
        @click="onAddClicked"
      >
        <IconCircleDashedPlus
          class="size-6"
        />
      </ShdnUiButton>
    </template>
    <template #header-pivot>
      <twice-ui-pivot>
        <twice-ui-pivot-item
          :active-route-query="{view: null}"
          active-route-path="/app/contacts"
          exact
          label="Alle Kontakte"
          route-name="contacts-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'orgs'}"
          :route-query="{view: 'orgs'}"
          active-route-path="/app/contacts"
          label="nur Organisationen"
          route-name="contacts-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'debtors'}"
          :route-query="{view: 'debtors'}"
          active-route-path="/app/contacts"
          label="Debitoren"
          route-name="contacts-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'creditors'}"
          :route-query="{view: 'creditors'}"
          active-route-path="/app/contacts"
          label="Kreditoren"
          route-name="contacts-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'archived'}"
          :route-query="{view: 'archived'}"
          active-route-path="/app/contacts"
          label="Archivierte Kontakte"
          route-name="contacts-list"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <twice-ui-table-box
        :loading="isLoading"
        :meta="meta"
        :record-count="contacts?.length"
        record-name="Kontakte"
        @update-page="onUpdatePage"
      >
        <template #header>
          <router-view />
        </template>
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
