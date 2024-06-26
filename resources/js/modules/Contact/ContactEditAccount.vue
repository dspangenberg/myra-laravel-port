<script setup lang="ts">
import { ref } from 'vue'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'

const contactStore = useContactStore()
const { paymentDeadlines, taxes, contactEdit } = storeToRefs(contactStore)

const isDebtor = ref(contactEdit.value?.is_debtor)
const isCreditor = ref(false)

const onDebtorChange = (value: boolean) => {
  isDebtor.value = value
}
const onCreditorChange = (value: boolean) => {
  isCreditor.value = value
}

</script>

<template>
  <div>
    <twice-ui-form-group>
      <div class="col-span-12 flex space-x-3 items-center">
        <twice-ui-check-box
          name="is_debtor"
          label="Debitor"
          @input="onDebtorChange"
        />
        <twice-ui-check-box
          name="is_creditor"
          label="Kreditior"
          @input="onCreditorChange"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      v-if="isDebtor"
      title="Debitorendaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          name="debtor_number"
          label="Debitornummer"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-select
          :options="taxes"
          name="tax_id"
          label="Steuersatz"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-select
          :options="paymentDeadlines"
          name="payment_deadline_id"
          label="Zahlungsziel"
        />
        <div class="pt-1">
          <twice-ui-check-box
            name="has_dunning_block"
            label="Mahnsperre"
          />
        </div>
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Registerdaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          name="register_court"
          label="Registergericht"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-input
          name="register_number"
          label="Registernummer"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Steuerdaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          name="vat_id"
          label="Umsatzsteuer-ID"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-input
          name="tax_number"
          label="Steuernummer"
        />
      </div>
    </twice-ui-form-group>
  </div>
</template>
