<script lang="ts" setup>
import { computed, ref, reactive } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Contact } from '@/api/Contact'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import ContactEditAdvanced from './ContactEditAdvanced.vue'
import ContactEditBase from './ContactEditBase.vue'
import ContactEditAccount from './ContactEditAccount.vue'
import type { FormData } from '@/types'
const contactStore = useContactStore()
const { baseUrl, contact, contactEdit } = storeToRefs(contactStore)

const router = useRouter()
const route = useRoute()
const formRef = ref(null)
const activeTab = ref('base')

const onClose = () => {
  if (route.params?.id) {
    router.push({ name: 'contacts-details', params: { id: route.params.id } })
  } else {
    router.push({ name: 'contacts-list' })
  }
}

const title = computed(() => contact.value?.full_name + ' bearbeiten')

const component = computed(() => {
  switch (activeTab.value) {
    case 'base':
      return ContactEditBase
    case 'advanced':
      return ContactEditAdvanced
    case 'account':
      return ContactEditAccount
    default:
      return ContactEditBase
  }
})

const onValidated = async (values: FormData) => {
  console.log(values)
  await contactStore.save(contactEdit.value as unknown as Contact)
  onClose()
}

</script>

<template>
  <div>
    <TwiceUiDialog
      :show="true"
      :title="title"
      width="md"
      @hide="onClose"
    >
      <template #header>
        <twice-ui-tabs v-model="activeTab">
          <twice-ui-tab
            name="base"
            title="Stammdaten"
          />
          <twice-ui-tab
            name="advanced"
            title="Weitere Daten"
          />
          <twice-ui-tab
            name="account"
            title="Debitor-, Kreditor und Firmendaten"
          />
        </twice-ui-tabs>
      </template>
      <template #content>
        <twice-ui-precognitive-form
          id="form"
          ref="formRef"
          :base-url="baseUrl"
          :initial-values="contactEdit as unknown as FormData"
          @validated="onValidated"
        >
          <component :is="component" />
        </twice-ui-precognitive-form>
      </template>
      <template #footer>
        <twice-ui-button @click="onClose">
          Abbrechen
        </twice-ui-button>
        <twice-ui-button
          form="form"
          type="submit"
          variant="primary"
        >
          Speichern
        </twice-ui-button>
      </template>
    </TwiceUiDialog>
  </div>
</template>
