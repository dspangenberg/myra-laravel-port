<script lang="ts" setup>
import { computed } from 'vue'
import ContactEditBaseOrg from '@/modules/Contact/ContactEditBaseOrg.vue'
import ContactEditBasePerson from '@/modules/Contact/ContactEditBasePerson.vue'
import ContactEditBaseMail from '@/modules/Contact/ContactEditBaseMail.vue'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
const contactStore = useContactStore()
const { contactEdit } = storeToRefs(contactStore)

const component = computed(() => contactEdit.value?.is_org ? ContactEditBaseOrg : ContactEditBasePerson)

</script>
<template>
  <div>
    <component :is="component" />
  </div>
  <twice-ui-form-group title="E-Mail-Adressen">
    <div class="col-span-24">
      <div
        v-for="mail in contactEdit?.mails"
        :key="mail.id"
      >
        <ContactEditBaseMail :item="mail" />
      </div>
      <twice-ui-button @click="contactStore.addMail(34)">
        Hinzufügen
      </twice-ui-button>
    </div>
  </twice-ui-form-group>
</template>
