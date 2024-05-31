<script lang="ts" setup>
import type { InstructionCategory } from '@/api/params/InstructionCategories'

import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: InstructionCategory
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow
    class="!cursor-pointer"
    @click="$emit('select', item.id)"
  >
    <TableCell class="w-16 text-center">
      <div
        class="rounded-full w-4 h-4 border border-white ml-4"
        :style="{backgroundColor: item.color}"
      />
    </TableCell>
    <TableCell class="font-semibold">
      {{ item.name }}
    </TableCell>
    <TableCell class="text-right w-16">
      0
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
