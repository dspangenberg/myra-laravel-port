<script lang="ts" setup>
import { computed, ref, reactive } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Contact } from '@/api/Contact'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { type Option } from '@/types'
const contactStore = useContactStore()
const { editContactPerson, contact, salutations, titles } = storeToRefs(contactStore)

const form = reactive(editContactPerson)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const onClose = () => {
  router.push({ name: 'contacts-details', params: { id: route.params.id } })
}

const title = computed(() => `Kontakt zu ${contact.value?.full_name} hinzufügen`)

const onSubmit = async (values: Contact) => {
  console.log(values)
  await contactStore.save(values)
  await contactStore.findById((route.params.id as unknown) as number)
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
      <template #content>
        <twice-ui-form
          id="form"
          ref="formRef"
          :initial-values="form"
          @submitted="onSubmit"
        >
          <twice-ui-form-group>
            <div class="col-span-3">
              <twice-ui-select
                :options="salutations as unknown as Option[]"
                label="Anrede"
                name="saluation_id"
                option-name="gender"
              />
            </div>
            <div class="col-span-5">
              <twice-ui-select
                :options="titles as unknown as Option[]"
                label="Title"
                name="title_id"
              />
            </div>
            <div class="col-span-6">
              <twice-ui-input
                label="Vorname"
                name="first_name"
                rules="required"
              />
            </div>
            <div class="col-span-10">
              <twice-ui-input
                label="Nachname"
                name="name"
                rules="required"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Position"
                name="position"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Abteilung"
                name="department"
              />
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
