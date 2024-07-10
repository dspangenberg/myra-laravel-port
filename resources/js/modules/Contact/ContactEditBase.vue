<script lang="ts" setup>
import { computed } from 'vue'
import ContactEditBaseOrg from '@/modules/Contact/ContactEditBaseOrg.vue'
import ContactEditBasePerson from '@/modules/Contact/ContactEditBasePerson.vue'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { type Option } from '@/types'

const contactStore = useContactStore()
const { contactEdit, emailCategories } = storeToRefs(contactStore)

const component = computed(() => contactEdit.value?.is_org ? ContactEditBaseOrg : ContactEditBasePerson)

</script>
<template>
  <div>
    <component :is="component" />
  </div>
  <twice-ui-form-group title="E-Mail-Adressen">
    <div class="col-span-24">
      <div
        v-for="(mail, index) in contactEdit?.mails"
        :key="mail.id"
        class="grid grid-cols-24 gap-x-2"
      >
        <div class="col-span-12">
          {{ mail }}
          <twice-ui-select
            :name="'mails.' + index + '.email_category_id'"
            :options="emailCategories as unknown as Option[]"
          />
          <twice-ui-input
            :name="'mail.0.contact_id'"
          />
          <twice-ui-input :name="'mail.email'" />
        </div>
      </div>
      <twice-ui-button @click="contactStore.addMail(34)">
        Hinzufügen
      </twice-ui-button>
    </div>
  </twice-ui-form-group>
</template>
