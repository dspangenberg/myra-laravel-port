import dayjs from 'dayjs'
import duration from 'dayjs/plugin/duration'
import relativeTime from 'dayjs/plugin/relativeTime'
import 'dayjs/locale/de'

dayjs.extend(duration)
dayjs.extend(relativeTime)
dayjs.locale('de')

export function useTemplateFilter () {
  const collectField = <T extends Array<any>>(collection: T, field: string) => {
    const records = collection.map<T>(item => item[field])
    return records.join(', ')
  }

  const formatDate = (date: string | undefined, format: string = 'DD.MM.YYYY') => {
    if (date === undefined) return ''
    return dayjs(date).format(format)
  }

  const formatDuration = (duration: number) => {
    return dayjs.duration(duration, 'minutes').format('H:mm')
  }

  return { collectField, formatDate, formatDuration }
}
