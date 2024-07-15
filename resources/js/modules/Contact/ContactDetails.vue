<script lang="ts" setup>
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

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/shdn/ui/card'
import { Button } from '@/components/shdn/ui/button'

import {
  MoreVertical
} from 'lucide-vue-next'
import { Separator } from '@/components/shdn/ui/separator'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/shdn/ui/dropdown-menu'

import { IconPencil, IconUserPlus, IconDots } from '@tabler/icons-vue'
import { useTemplateFilter } from '@/composables/useTemplateFilter'

const { formatNumber } = useTemplateFilter()
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
            :fullname="contact?.full_name"
            :initials="contact?.initials"
            avatar="null"
            size="lg"
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
    <template #header-pivot>
      <twice-ui-pivot>
        <twice-ui-pivot-item
          active-route-path="/app/contacts"
          label="Historie"
          route-name="contacts-details"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'all'}"
          :route-params="{type: 'list'}"
          :route-query="{view: 'all'}"
          active-route-path="/app/times/list"
          label="Kontakte"
          route-name="times-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'billable'}"
          :route-params="{type: 'list'}"
          :route-query="{view: 'billable'}"
          active-route-path="/app/times/list"
          label="Projekte"
          route-name="times-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'billable'}"
          :route-params="{type: 'list'}"
          :route-query="{view: 'billable'}"
          active-route-path="/app/times/list"
          label="Verträge"
          route-name="times-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'billable'}"
          :route-params="{type: 'list'}"
          :route-query="{view: 'billable'}"
          active-route-path="/app/times/list"
          label="Dokumente"
          route-name="times-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'billable'}"
          :route-params="{type: 'list'}"
          :route-query="{view: 'billable'}"
          active-route-path="/app/times/list"
          label="Fakturierung"
          route-name="times-list"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <div class="px-0.5 flex space-x-8 mt-6">
        <div class="flex-1">
          {{ contact }}
        </div>
        <Card
          v-if="contact"
          class="overflow-hidden w-96"
        >
          <CardHeader class="flex bg-muted/50 border-4  flex-1 flex-col ">
            <div class="flex-1 border-4 flex flex-col">
              <CardTitle class="group text-lg truncate flex-1">
                {{ contact?.company?.full_name || contact?.full_name }}
              </CardTitle>
              <CardDescription>
                Account
              </CardDescription>
            </div>
            <div class="flex flex-shrink items-center gap-1 border-4">
              <DropdownMenu>
                <DropdownMenuTrigger as-child>
                  <Button
                    class="h-8 w-8"
                    size="icon"
                    variant="outline"
                  >
                    <MoreVertical class="h-3.5 w-3.5" />
                    <span class="sr-only">More</span>
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                  <DropdownMenuItem @click="onEdit">
                    Bearbeiten
                  </DropdownMenuItem>
                  <DropdownMenuItem>Export</DropdownMenuItem>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem>Trash</DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </div>
          </CardHeader>
          <CardContent class="p-6 text-sm">
            <div class="grid gap-3">
              <div class="font-semibold">
                Debitordaten:
              </div>
              <ul class="grid gap-3 ">
                <li class="flex items-center justify-between text-sm">
                  <span class="text-muted-foreground">
                    Debitor- und Kundennr.:
                  </span>
                  <span>
                    {{ formatNumber(contact?.debtor_number, 0) }}
                  </span>
                </li>
                <li class="flex items-center justify-between text-sm">
                  <span class="text-muted-foreground">
                    Zahlungsziel:
                  </span>
                  <span>
                    {{ contact.payment_deadline.name }} <span v-if="contact.has_dunning_block">(M-Sperre)</span>
                  </span>
                </li>
                <li class="flex items-center justify-between text-sm">
                  <span class="text-muted-foreground">
                    Umsatzsteuer:
                  </span>
                  <span>
                    {{ contact.tax.name }}
                  </span>
                </li>
                <li class="flex items-center justify-between">
                  <span class="text-muted-foreground">Stundensatz:</span>
                  <span>60,00 EUR</span>
                </li>
              </ul>
              <Separator class="my-4" />
              <div class="font-semibold">
                Register- und Steuerdaten:
              </div>
              <ul class="grid gap-3">
                <li class="flex items-center justify-between">
                  <span class="text-muted-foreground">
                    Register / Firmenbuch:
                  </span>
                  <span>
                    {{ contact.register_court }} ({{ contact.register_number }})
                  </span>
                </li>
                <li class="flex items-center justify-between">
                  <span class="text-muted-foreground">
                    Umsatzsteuer-ID:
                  </span>

                  <span>{{ contact.vat_id }}</span>
                </li>
                <li class="flex items-center justify-between">
                  <span class="text-muted-foreground">
                    Steuernr.:
                  </span>
                  <span>{{ contact?.tax_number }}</span>
                </li>
              </ul>
            </div>
            <Separator class="my-4" />
            <div class="grid grid-cols-2 gap-4">
              <div class="grid gap-3">
                <div class="font-semibold">
                  Rechnungsanschrift:
                </div>
                <address class="grid gap-0.5 not-italic text-muted-foreground">
                  <span>twiceware solutions e. K.</span>
                  <span>Belderberg 7</span>
                  <span>53111 Bonn</span>
                </address>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
      <router-view />
    </template>
  </TwiceUiPageLayout>
</template>
