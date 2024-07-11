<!--suppress ALL -->
<script lang="ts" setup>
import { Button } from '@/components/shdn/ui/button'
import { IconReceiptEuro, IconSearch, IconLayoutKanban, IconBell, IconClockEdit, IconGauge, IconBuildingCommunity, IconContract, IconFolder } from '@tabler/icons-vue'
import UserMenu from './UserMenu.vue'
import { container as WidgetContainerModal } from 'jenesius-vue-modal'
</script>

<template>
  <div class="flex flex-1 w-full md:pl-64 overflow-hidden h-screen">
    <aside
      class="fixed left-0 z-20 flex-col hidden h-full border-r inset-y md:flex border-stone-200/50 w-64 bg-stone-100/75"
    >
      <div class="mx-auto my-6">
        <img
          alt="twiceware-Logo"
          class="size-12"
          src="@/assets/tw.png"
        >
      </div>
      <div class="p-2 mb-6">
        <button
          class="hidden w-full max-w-64 ring-1 ring-gray-900/10 bg-white lg:flex items-center text-base leading-6 text-gray-400 rounded  py-1.5 pl-2 pr-3 focus:ring-blue-200 focus:outline-none "
          type="button"
        >
          <IconSearch class="mr-2 size-4" />
          Suchen...
          <span class="flex-none pl-3 ml-auto text-sm font-medium">⌘K</span>
        </button>
      </div>
      <nav class="grid divide-y divide-stone-100 divide-stone-200/50 border-stone-200/50 border-b">
        <div class="grid gap-1 p-2">
          <TwiceUiNavItem
            label="Dashboard"
            route-name="dashboard"
          >
            <template #icon="{ iconProps }">
              <IconGauge
                exact
                v-bind="iconProps"
              />
            </template>
          </TwiceUiNavItem>
        </div>
        <div class="grid gap-1 p-2 ">
          <TwiceUiNavItem
            active-route-path="/app/contacts"
            label="Accounts + Kontakte"
            route-name="contacts-list"
          >
            <template #icon="{ iconProps }">
              <IconBuildingCommunity v-bind="iconProps" />
            </template>
          </TwiceUiNavItem>
          <TwiceUiNavItem
            active-route-path="/app/agenda"
            label="Dokumente"
            route-name="agenda"
          >
            <template #icon="{ iconProps }">
              <IconFolder v-bind="iconProps" />
            </template>
          </TwiceUiNavItem>
          <TwiceUiNavItem
            active-route-path="/app/projects"
            label="Projekte"
            route-name="projects-list"
          >
            <template #icon="{ iconProps }">
              <IconLayoutKanban v-bind="iconProps" />
            </template>
          </TwiceUiNavItem>
          <TwiceUiNavItem
            active-route-path="/app/agenda"
            label="Verträge"
            route-name="agenda"
          >
            <template #icon="{ iconProps }">
              <IconContract v-bind="iconProps" />
            </template>
          </TwiceUiNavItem>
        </div>
        <div class="grid gap-1 p-2 ">
          <TwiceUiNavItem
            :route-params="{ type: 'week' }"
            active-route-path="/app/times"
            label="Zeiterfassung"
            route-name="times-list"
          >
            <template #icon="{ iconProps }">
              <IconClockEdit v-bind="iconProps" />
            </template>
          </TwiceUiNavItem>
          <TwiceUiNavItem
            active-route-path="/app/invoicing"
            label="Fakturierung + Fibu"
            route-name="receipts-list"
          >
            <template #icon="{ iconProps }">
              <IconReceiptEuro v-bind="iconProps" />
            </template>
            <template #default>
              <twice-ui-sub-nav-item
                active-route-path="/app/invoicing/receipts"
                label="Belege"
                route-name="receipts-list"
              />
            </template>
          </TwiceUiNavItem>
        </div>
      </nav>
    </aside>
    <div class="flex flex-col flex-1 overflow-hidden">
      <header class="sticky top-0 z-10 flex h-[57px] items-center gap-1  px-4 pt-2 flex-none border-stone-100">
        <div class="flex-1">
          <widget-container-modal />
        </div>
        <div class="p-2">
          <Button
            v-tooltip="'Benachrichtigungen'"
            class="text-gray-700 rounded-lg"
            disabled
            size="icon"
            variant="ghost"
          >
            <IconBell class="size-6" />
          </Button>
        </div>
        <div class="mt-1">
          <UserMenu />
        </div>
      </header>
      <main class="flex flex-1 flex-col bg-stone-50 h-full overflow-y-hidden">
        <router-view />
      </main>
    </div>
  </div>
</template>
