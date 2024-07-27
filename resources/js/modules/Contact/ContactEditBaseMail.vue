<script lang="ts" setup>
import { computed, toRefs } from 'vue'
import ContactEditBaseOrg from '@/modules/Contact/ContactEditBaseOrg.vue'
import ContactEditBasePerson from '@/modules/Contact/ContactEditBasePerson.vue'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { type Option } from '@/types'
import type { Contact, ContactMail } from '@/api/Contact'

const contactStore = useContactStore()
const { contactEdit, emailCategories } = storeToRefs(contactStore)

const component = computed(() => contactEdit.value?.is_org ? ContactEditBaseOrg : ContactEditBasePerson)
export interface Props {
  item: ContactMail
}

const props = defineProps<Props>()
// eslint-disable-next-line camelcase
const { item } = toRefs(props)

</script>
<template>
  <div class="grid grid-cols-24 gap-2">
    <div class="col-span-6">
      <twice-ui-form-select
        v-model="item.email_category_id"
        :options="emailCategories as unknown as Option[]"
      />
    </div>
    <div class="col-span-12">
      <twice-ui-form-input
        v-model="item.email"
      />
    </div>
  </div>
</template>
