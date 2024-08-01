<script lang="ts" setup>
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
const contactStore = useContactStore()
const { contactEdit } = storeToRefs(contactStore)
</script>
<template>
  <div v-if="contactEdit">
    <twice-ui-form-group>
      <div class="col-span-24">
        <twice-ui-form-input
          v-model="contactEdit.name"
          label="Name"
          rules="required"
        />
      </div>
    </twice-ui-form-group>
  </div>
</template>
