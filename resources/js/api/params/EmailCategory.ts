import EmailCategory from './EmailCategory'
export interface ContactEMail {
  id?: number | null
  contact_id: number
  e_email_category_id: number
  category: EmailCategory
  pos: number
  email: string
}
