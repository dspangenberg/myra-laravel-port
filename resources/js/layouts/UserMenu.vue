<script setup lang="ts">
import { IconUserSquareRounded, IconLifebuoy, IconSettings, IconUsersGroup, IconLogout, IconTableOptions } from '@tabler/icons-vue'
import { computed } from 'vue'
import { useRouter } from 'vue-router'

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger
} from '@/components/shdn/ui/dropdown-menu'
import { useGlobalStore } from '@/stores/GlobalStore'

const router = useRouter()
const globalStore = useGlobalStore()
const user = computed(() => globalStore.getUser)

const onLogoutClicked = () => {
  router.push({ name: 'logout' })
}

const onAccountsClicked = () => {
  router.push({ name: 'users-list' })
}

const onParamsClicked = () => {
  router.push({ name: 'params-business-segments' })
}

const iconProps = {
  size: '20',
  stroke: '1.5'
}

</script>
<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <button class="flex flex-1 p-1 mx-1 my-1 border border-transparent rounded-md hover:border-gray-200 hover:bg-white active:bg-white">
        <div class="flex items-center flex-none w-full">
          <twice-ui-avatar
            :avatar="user.avatar_url"
            :initials="user.initials"
            :fullname="user.full_name"
            size="sm"
          />
        </div>
      </button>
    </DropdownMenuTrigger>
    <DropdownMenuContent
      class="w-56 mx-3"
      side="bottom"
      :side-offset="6"
    >
      <DropdownMenuGroup>
        <DropdownMenuItem disabled>
          <IconUserSquareRounded v-bind="iconProps" />
          <span class="px-2">Mein Profil</span>
          <DropdownMenuShortcut>⇧⌘P</DropdownMenuShortcut>
        </DropdownMenuItem>
        <DropdownMenuSeparator />
        <DropdownMenuItem disabled>
          <IconSettings v-bind="iconProps" />
          <span class="px-2">Einstellungen</span>
          <DropdownMenuShortcut>⌘S</DropdownMenuShortcut>
        </DropdownMenuItem>
        <DropdownMenuItem @click="onParamsClicked">
          <IconTableOptions v-bind="iconProps" />
          <span class="px-2">Parameterdaten</span>
          <DropdownMenuShortcut>⌘S</DropdownMenuShortcut>
        </DropdownMenuItem>
        <DropdownMenuSeparator />
        <DropdownMenuItem
          :disabled="user.is_admin === false"
          @click="onAccountsClicked"
        >
          <IconUsersGroup v-bind="iconProps" />
          <span class="px-2">Benutzer*innen</span>
        </DropdownMenuItem>
      </DropdownMenuGroup>
      <DropdownMenuSeparator />
      <DropdownMenuItem disabled>
        <IconLifebuoy v-bind="iconProps" />
        <span class="px-2">Hilfe + Support</span>
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem @click="onLogoutClicked">
        <IconLogout v-bind="iconProps" />
        <span class="px-2">Abmelden</span>
        <DropdownMenuShortcut>⇧⌘Q</DropdownMenuShortcut>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
