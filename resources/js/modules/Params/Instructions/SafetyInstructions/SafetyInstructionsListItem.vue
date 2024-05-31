<script lang="ts" setup>
import type { OperatingInstruction } from '@/api/params/OperatingInstruction'
import { RouterLink } from 'vue-router'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: OperatingInstruction
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow>
    <TableCell class="w-24">
      {{ item.number }}
    </TableCell>
    <TableCell class="font-medium">
      <RouterLink :to="{ name: 'settings-instructions-operating-instructions-edit', params: { id: item.id }}">
        {{ item.name }}
      </RouterLink>
    </TableCell>
  </TableRow>
</template>
