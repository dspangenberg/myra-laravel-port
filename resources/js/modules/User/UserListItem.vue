<script lang="ts" setup>
import type { User } from '@/api/User'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: User
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow @click="$emit('select', item.id)">
    <TableCell>
      <twice-ui-avatar
        size="sm"
        :avatar="item.avatar_url"
        :fullname="item.full_name"
        :initials="item.initials"
      />
    </TableCell>
    <TableCell class="font-medium">
      {{ item.reverse_full_name }}
    </TableCell>
    <TableCell>
      {{ item.email }}
    </TableCell>
  </TableRow>
</template>
