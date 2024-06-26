<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Contact } from '@/api/Contact'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'

const contactStore = useContactStore()
const { contactEdit } = storeToRefs(contactStore)

const form = reactive(contactEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const onClose = () => {
  if (route.params?.id) {
    router.push({ name: 'contacts-details', params: { id: route.params.id } })
  } else {
    router.push({ name: 'contacts-list' })
  }
}

const contactIsOrg = ref(false)

const onSubmit = async (values: Contact) => {
  await contactStore.save(values)
  onClose()
}

</script>

<template>
  <div>
    <TwiceUiDialog
      :show="true"
      title="Einzelkontakt oder Organisation hinzufügen"
      width="md"
      @hide="onClose"
    >
      <template #content>
        <twice-ui-form
          id="form"
          ref="formRef"
          :initial-values="form"
          @submitted="onSubmit"
        >
          <twice-ui-form-group>
            <div class="col-span-24">
              <twice-ui-native-check-box
                v-model="contactIsOrg"
                label="Organisation anstatt Einzelkontakt hinzufügen"
              />
            </div>
          </twice-ui-form-group>
          <twice-ui-form-group v-if="contactIsOrg">
            <div class="col-span-24">
              <twice-ui-input
                label="Name"
                rules="required"
                name="name"
              />
            </div>
          </twice-ui-form-group>
          <twice-ui-form-group v-else>
            <div class="col-span-12">
              <twice-ui-input
                label="Vorname"
                rules="required"
                name="firstname"
              />
              <div class="col-span-12">
                <twice-ui-input
                  label="Name"
                  rules="required"
                  name="name"
                />
              </div>
            </div>
          </twice-ui-form-group>
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
