<script setup lang="ts">
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage, BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import { IconPencil, IconUserPlus, IconDots } from '@tabler/icons-vue'

const contactStore = useContactStore()
const { contact } = storeToRefs(contactStore)

const route = useRoute()
const router = useRouter()
const id = computed<number>(() => parseInt(route.params.id as string))
const companyRoute = computed(() => `/app/contacts/${contact.value?.company_id}`)

watch(id, async (id: number) => {
  await contactStore.findById(id)
}, { immediate: true })

const onEdit = async () => {
  await contactStore.createOrEdit(route.params?.id as unknown as number)
  console.log(contact.value)
  router.push({ name: 'contacts-edit', params: { id: route.params?.id } })
}

const onAddContact = async () => {
  await contactStore.addContactToOrg(route.params?.id as unknown as number)
  router.push({ name: 'contacts-person-add' })
}

</script>

<template>
  <TwiceUiPageLayout>
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
            <BreadcrumbLink href="/app/contacts">
              Accounts + Kontakte
            </BreadcrumbLink>
          </BreadcrumbItem>
          <template v-if="contact?.company_id !== 0">
            <BreadcrumbSeparator />
            <BreadcrumbLink :href="companyRoute">
              <p
                class="max-w-[16rem] truncate"
              >
                {{ contact?.company?.name }}
              </p>
            </BreadcrumbLink>
          </template>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbPage>
              <p
                class="max-w-[16rem] truncate"
              >
                {{ contact?.full_name }}
              </p>
            </BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-title>
      <div class="flex items-center space-x-4">
        <div class="flex-none">
          <TwiceUiAvatar
            avatar="null"
            size="lg"
            :fullname="contact?.full_name"
            :initials="contact?.initials"
          />
        </div>
        <div class="flex-1">
          <h1 class="text-xl text-gray-900 font-medium max-w-[40rem] break-words leading-relaxed">
            {{ contact?.full_name }}
          </h1>
          <div
            v-if="contact?.company_id"
            class="text-base text-gray-500"
          >
            <p
              class="max-w-[40rem] break-words leading-relaxed"
            >
              <router-link :to="companyRoute">
                {{ contact?.company?.name }}
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </template>
    <template #header-toolbar>
      <ShdnUiButton
        size="icon"
        variant="ghost"
        @click="onEdit"
      >
        <IconPencil
          class="size-6"
        />
      </ShdnUiButton>
      <ShdnUiButton
        size="icon"
        variant="ghost"
        @click="onAddContact"
      >
        <IconUserPlus
          class="size-6"
        />
      </ShdnUiButton>
      <ShdnUiButton
        size="icon"
        variant="ghost"
        @click="onEdit"
      >
        <IconDots
          class="size-6"
        />
      </ShdnUiButton>
    </template>
    <template #content-full>
      <div class="px-0.5 flex">
        <div class="flex-1">
          {{ contact }}
        </div>
        <twice-ui-info-box>
          <div class="grid grid-cols-3">
            <twice-ui-dl
              label="Debitor-Nr."
              :value="contact?.debtor_number"
            />
            <twice-ui-dl
              label="Zahlungsziel"
              :value="contact?.payment_deadline?.name"
            />
            <twice-ui-dl
              label="Steuer"
              :value="contact?.tax?.name"
            />
          </div>
          <div class="grid grid-cols-2">
            <twice-ui-dl
              label="Umsatzsteuer-ID"
              :value="contact?.vat_id"
            />
          </div>
          <div class="grid grid-cols-2">
            <twice-ui-dl
              label="Registergericht"
              :value="contact?.register_court"
            />
            <twice-ui-dl
              label="Nr."
              :value="contact?.register_number"
            />
          </div>
        </twice-ui-info-box>
      </div>
      <router-view />
    </template>
  </TwiceUiPageLayout>
</template>
