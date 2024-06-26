import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllContacts, findContactById, createContact, updateContact, createOrEditContact } from '@/api/Contact'
import { ref, type Ref } from 'vue'

import { type Meta } from '@/types/'
import type { Contact, ContactMail } from '@/api/Contact'

import { type AddressCategory } from '@/api/params/AddressCategory'
import { type Country } from '@/api/params/Country'
import { type EmailCategory } from '@/api/params/EmailCategory'
import { type PaymentDeadline } from '@/api/params/PaymentDeadline'
import { type PhoneCategory } from '@/api/params/PhoneCategory'
import { type Salutation } from '@/api/params/Salutation'
import { type Tax } from '@/api/params/Tax'
import { type Title } from '@/api/params/Title'

export const useContactStore = defineStore('contact-store', () => {
  const contacts: Ref<Contact[] | null> = ref([])
  const contact: Ref<Contact | null> = ref(null)
  const contactEdit: Ref<Contact | null> = ref(null)

  const addressCategories: Ref<AddressCategory[] | null> = ref([])
  const countries: Ref<Country[] | null> = ref([])
  const emailCategories: Ref<EmailCategory[] | null> = ref([])
  const paymentDeadlines: Ref<PaymentDeadline[] | null> = ref([])
  const phoneCategories: Ref<PhoneCategory[] | null> = ref([])
  const salutations: Ref<Salutation[] | null> = ref([])
  const taxes: Ref<Tax[] | null> = ref([])
  const titles: Ref<Title[] | null> = ref([])
  const editContactPerson: Ref<Contact | null> = ref(null)

  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useContactStore()

  const getAll = async (qs: string) => {
    isLoading.value = true
    const { data, meta } = await getAllContacts(qs)
    store.$patch(state => {
      state.contacts = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const addMail = (contactId: number) => {
    store.$patch(state => {
      state.contactEdit.mails.push({
        e_email_category_id: 0,
        contact_id: contactId,
        pos: 0,
        email: ''
      })
    })
  }

  const addContactToOrg = async (companyId: number) => {
    const data = await createOrEditContact()
    console.log(data)
    const person = Object.assign({}, data.data)
    person.company_id = companyId

    store.$patch(state => {
      state.editContactPerson = person
      state.salutations = data.salutations
      state.titles = data.titles
    })
  }
  const createOrEdit = async (id?: number) => {
    const data = await createOrEditContact(id)

    store.$patch(state => {
      state.addressCategories = data.address_categories
      state.countries = data.countries
      state.emailCategories = data.email_categories
      state.paymentDeadlines = data.payment_deadlines
      state.phoneCategories = data.phone_categories
      state.salutations = data.salutations
      state.taxes = data.taxes
      state.titles = data.titles
      state.contact = data.data
      state.contactEdit = data.data
    })
  }

  const findById = async (id: number) => {
    const { data } = await findContactById(id)

    store.$patch(state => {
      state.contact = data
      state.contactEdit = data
    })
  }

  const save = async (value: Contact, callContacts: boolean = true) => {
    console.log(value)
    if (!value.id) {
      await createContact(value)
    } else {
      await updateContact(value)
    }
    contactEdit.value = null

    if (callContacts) {
      await getAll('')
    }
  }

  return {
    isLoading,
    contact,
    contactEdit,
    contacts,
    editContactPerson,
    meta,

    addressCategories,
    countries,
    emailCategories,
    paymentDeadlines,
    phoneCategories,
    salutations,
    taxes,
    titles,

    addMail,
    addContactToOrg,
    createOrEdit,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useContactStore, import.meta.hot))
}
