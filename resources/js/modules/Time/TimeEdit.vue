<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { type Time } from '@/api/Time'
import { storeToRefs } from 'pinia'
import { useTimeStore } from '@/stores/TimeStore'
import type { Option } from '@/types'

const timeStore = useTimeStore()

const { timeEdit, categories, projects, users } = storeToRefs(timeStore)

const form = reactive(timeEdit)
const router = useRouter()
const formRef = ref(null)
s
const onClose = () => {
  router.push({ name: 'times-list' })
}

const onSubmit = async (values: Time) => {
  await timeStore.save(values)
  onClose()
}

</script>

<template>
  <div>
    <TwiceUiDialog
      :show="true"
      title="Zeiteintrag hinzufügen"
      width="lg"
      @hide="onClose"
    >
      <template #content>
        <TwiceUiForm
          id="form"
          ref="formRef"
          :initial-values="form"
          @submitted="onSubmit"
        >
          <twice-ui-form-group>
            <div class="col-span-6">
              <twice-ui-input
                name="begin_at"
                label="Start"
              />
            </div>
            <div class="col-span-6">
              <twice-ui-input
                name="end_at"
                label="Ende"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-select
                label="Project"
                rules="required"
                name="project_id"
                :options="projects as unknown as Option[]"
              />
            </div>
            <div class="col-span-24">
              <twice-ui-input
                name="note"
                type="textarea"
                label="Notizen"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-select
                label="Leistung"
                rules="required"
                name="time_category_id"
                :options="categories as unknown as Option[]"
              />
              <div class="pt-1 flex items-center space-x-2">
                <twice-ui-check-box
                  label="abrechenbar"
                  name="is_billable"
                />
                <twice-ui-check-box
                  label="gesperrt"
                  name="is_locked"
                />
              </div>
            </div>
            <div class="col-span-12">
              <twice-ui-select
                label="Mitarbeiter*in"
                rules="required"
                name="user_id"
                option-name="full_name"
                :options="users as unknown as Option[]"
              />
            </div>
          </twice-ui-form-group>
        </TwiceUiForm>
      </template>
      <template #footer>
        <ShdnUiButton
          variant="secondary"
          @click="onClose"
        >
          Abbrechen
        </ShdnUiButton>
        <ShdnUiButton
          form="form"
          type="submit"
        >
          Speichern
        </ShdnUiButton>
      </template>
    </TwiceUiDialog>
  </div>
</template>
