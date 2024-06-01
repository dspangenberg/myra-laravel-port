import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllContacts, findContactById, createContact, updateContact } from '@/api/Contact'
import { reactive, ref, type Ref } from 'vue'
import type { Contact } from '@/api/Contact'
import { type Meta } from '@/types/'

export const useContactStore = defineStore('contact-store', () => {
  const contacts: Ref<Contact[] | null> = ref([])
  const contact: Ref<Contact | null> = ref(null)
  const contactEdit: Ref<Contact | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useContactStore()

  const newRecordTemplate = reactive({
    id: 0,
    company_id: 0,
    is_org: true,
    name: '',
    first_name: '',
    salutation_id: 0,
    title_id: 0,
    position: '',
    department: '',
    short_name: '',
    ref: '',
    debtor_number: 0,
    creditor_number: 0,
    is_debtor: false,
    is_creditor: false,
    is_archived: false,
    has_dunning_block: false,
    archived_reason: '',
    payment_deadline_id: 0,
    tax_id: 0,
    hourly: 0,
    register_court: '',
    register_number: '',
    vat_id: '',
    note: '',
    dob: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllContacts(page)
    store.$patch(state => {
      state.contacts = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.contact = newRecordTemplate
      state.contactEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { contact: record } = await findContactById(id)

    store.$patch(state => {
      state.contact = record
      state.contactEdit = record
    })
  }

  const save = async (value: Contact) => {
    if (!value.id) {
      await createContact(value)
    } else {
      await updateContact(value)
    }
    contactEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    contact,
    contactEdit,
    contacts,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useContactStore, import.meta.hot))
}
