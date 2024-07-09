<script setup lang="ts">
import { ref, reactive, provide } from 'vue'
import { useRouter } from 'vue-router'
import { type User } from '@/api/User'
import { useUserStore } from '@/stores/UserStore'
import { storeToRefs } from 'pinia'

const userStore = useUserStore()
const { userEdit } = storeToRefs(userStore)

const form = reactive<User>(userEdit.va)
console.log(form)
const router = useRouter()

const onClose = () => {
  router.push({ name: 'users-list' })
}

const onSubmit = async () => {
  // await userStore.save(form.data() as unknown as User)
  // await form
  // onClose()
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
          class="flex-1 flex w-full items-stretch flex-col"
          :initial-values="form"
          base-url="users"
          @submit.prevent="onSubmit"
        >
          <twice-ui-form-group>
            <div class="col-span-12">
              <twice-ui-input
                id="first_name"
                v-model="form.first_name"
                label="Vorname"
                required
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                id="last_name"
                v-model="form.last_name"
                label="Name"
                required
              />
            </div>
            <div class="col-span-24">
              <twice-ui-input
                id="email"
                v-model="form.email"
                required
                label="E-Mail-Adresse"
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
