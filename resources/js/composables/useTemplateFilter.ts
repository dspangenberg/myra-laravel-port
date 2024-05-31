export function useTemplateFilter () {
  const collectField = <T extends Array<any>>(collection: T, field: string) => {
    const records = collection.map<T>(item => item[field])
    return records.join(', ')
  }

  return { collectField }
}
