<!--suppress ALL -->
<script setup lang="ts">
import { Button } from '@/components/shdn/ui/button'
import { IconChalkboard, IconSearch, IconIdBadge2, IconBell, IconCheckupList, IconCalendarDot, IconGauge, IconAddressBook, IconWand, IconFolder, IconMenu2 } from '@tabler/icons-vue'
import UserMenu from './UserMenu.vue'

const iconProps = {
  size: '24',
  stroke: '1.5'
}

</script>

<template>
  <div class="flex flex-1 w-full md:pl-[53px] overflow-hidden">
    <aside
      class="fixed left-0 z-20 flex-col hidden h-full border-r inset-y md:flex border-stone-1 00 bg-stone-50"
    >
      <nav class="grid gap-1">
        <div class="px-3 py-2 my-2">
          <img
            src="@/assets/tw.png"
            class="size-8"
            alt="twiceware-Logo"
          >
        </div>
        <div class="grid gap-1 p-2 ">
          <Button
            v-tooltip="'Dashboard'"
            variant="ghost"
            size="icon"
            class="rounded-lg bg-muted"
            aria-label="Playground"
          >
            <IconGauge v-bind="iconProps" />
          </Button>
        </div>
        <div class="grid gap-1 p-2 ">
          <Button
            v-tooltip="'Kalender'"
            disabled
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconCalendarDot v-bind="iconProps" />
          </Button>

          <Button
            v-tooltip="'Kontakte'"
            disabled
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconAddressBook v-bind="iconProps" />
          </Button>

          <Button
            v-tooltip="'Dokumente'"
            disabled
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="Documentation"
          >
            <IconFolder v-bind="iconProps" />
          </Button>
        </div>
        <div class="grid gap-1 p-2 ">
          <Button
            v-tooltip="'Mitarbeitende'"
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconIdBadge2 v-bind="iconProps" />
          </Button>
          <Button
            v-tooltip="'Arbeitsmittel'"
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconWand v-bind="iconProps" />
          </Button>
        </div>
        <div class="grid gap-1 p-2 ">
          <Button
            v-tooltip="'Überprüfungen'"
            disabled
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconCheckupList v-bind="iconProps" />
          </Button>
          <Button
            v-tooltip="'Unterweisungen'"
            disabled
            variant="ghost"
            size="icon"
            class="rounded-lg"
            aria-label="API"
          >
            <IconChalkboard v-bind="iconProps" />
          </Button>
        </div>
      </nav>
    </aside>
    <div class="flex flex-col flex-1 overflow-hidden">
      <header class="sticky top-0 z-10 flex h-[57px] items-center gap-1  px-4 pt-2 flex-none border-stone-100 ">
        <Button
          v-tooltip="'Unterweisungen'"
          variant="ghost"
          size="icon"
          class="block rounded-lg md:hidden"
          aria-label="API"
        >
          <IconMenu2 v-bind="iconProps" />
        </Button>
        <div class="flex-1">
          <button
            type="button"
            class="hidden w-full max-w-64 ring-1 ring-gray-900/10 bg-white lg:flex items-center text-base leading-6 text-gray-400 rounded  py-1.5 pl-2 pr-3 focus:ring-blue-200 focus:outline-none "
          >
            <IconSearch class="mr-2 size-4" />
            Suchen...
            <span class="flex-none pl-3 ml-auto text-sm font-medium">⌘K</span>
          </button>
        </div>
        <div class="p-2">
          <Button
            v-tooltip.bottom="'Benachrichtigungen'"
            disabled
            variant="ghost"
            size="icon"
            class="text-gray-700 rounded-lg"
            aria-label="API"
          >
            <IconBell v-bind="iconProps" />
          </Button>
        </div>
        <div class="mt-1">
          <UserMenu />
        </div>
      </header>
      <main class="grid flex-1 px-4 py-6 overflow-hidden overflow-y-auto bg-white">
        <div class="container">
          <router-view />
        </div>
      </main>
    </div>
  </div>
</template>
