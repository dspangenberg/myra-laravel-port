<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { type User } from '@/api/User'
import { useUserStore } from '@/stores/UserStore'
import { storeToRefs } from 'pinia'

const userStore = useUserStore()
const { userEdit } = storeToRefs(userStore)

const form = reactive(userEdit)
const router = useRouter()
const formRef = ref(null)

const onClose = () => {
  router.push({ name: 'users-list' })
}

const onSubmit = async (values: User) => {
  await userStore.save(values)
  onClose()
}

</script>

<template>
  <div>
    <TwiceUiDialog
      :show="true"
      title="Benutzer*in hinzufügen"
      width="xs"
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
            <div class="col-span-12">
              <twice-ui-input
                label="Vorname"
                rules="required"
                name="first_name"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Name"
                rules="required"
                name="last_name"
              />
            </div>
            <div class="col-span-24">
              <twice-ui-input
                label="E-Mail-Adresse"
                rules="required|email"
                name="email"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Kennwort"
                rules="safe-password:14:score|confirmed:@password_confirmation"
                name="password"
              />
              <twice-ui-check-box
                name="is_admin"
                label="Administrator"
                :true-value="true"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Wiederholung"
                name="password_confirmation"
              />
            </div>
          </twice-ui-form-group>
        </twice-ui-form>
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
