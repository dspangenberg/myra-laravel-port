<script lang="ts" setup>
import type { Contact } from '@/api/Contact'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: Contact
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow @click="$emit('select', item.id)">
    <TableCell class="w-14">
      <TwiceUiAvatar
        avatar="null"
        :fullname="item?.full_name"
        :initials="item?.initials"
      />
    </TableCell>
    <TableCell class="w-[30rem] max-w-[30rem]">
      <p class="truncate font-medium">
        {{ item.reverse_full_name }}
      </p>
      <p
        v-if="item.company_id"
        class="truncate text-gray-600 pt-1 text-sm"
      >
        {{ item.company?.name }}
      </p>
    </TableCell>
    <TableCell>
      &nbsp;
    </TableCell>
  </TableRow>
</template>
