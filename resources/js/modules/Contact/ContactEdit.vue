<script setup lang="ts">
import { computed, ref, reactive } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Contact } from '@/api/Contact'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import ContactEditAdvanced from './ContactEditAdvanced.vue'
import ContactEditBase from './ContactEditBase.vue'
import ContactEditAccount from './ContactEditAccount.vue'

const contactStore = useContactStore()
const { contact, contactEdit } = storeToRefs(contactStore)

const form = reactive(contactEdit)
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

const onSubmit = async (values: Contact) => {
  console.log(values)
  await contactStore.save(values)
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
            title="Debitor-, Kreditor und Firmendaten"
            name="account"
          />
        </twice-ui-tabs>
      </template>
      <template #content>
        <twice-ui-form
          id="form"
          ref="formRef"
          :initial-values="form"
          @submitted="onSubmit"
        >
          <component :is="component" />
        </twice-ui-form>
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
