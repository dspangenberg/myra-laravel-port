import dayjs from 'dayjs'
import duration from 'dayjs/plugin/duration'
import relativeTime from 'dayjs/plugin/relativeTime'
import customParseFormat from 'dayjs/plugin/customParseFormat'

import 'dayjs/locale/de'

dayjs.extend(duration)
dayjs.extend(relativeTime)
dayjs.extend(customParseFormat)
dayjs.locale('de')

export function useTemplateFilter () {
  const collectField = <T extends Array<any>>(collection: T, field: string) => {
    const records = collection.map<T>(item => item[field])
    return records.join(', ')
  }

  const durationUntilNow = (date: string | undefined) => {
    const y = dayjs(date, 'DD.MM.YYYY HH:mm')
    const x = dayjs()
    const duration = dayjs.duration(x.diff(y)).asMinutes()
    return formatDuration(duration)
  }

  const formatDate = (date: string | undefined, format: string = 'DD.MM.YYYY', locale: string = 'de') => {
    if (date === undefined) return ''
    if (locale === 'de') {
      return dayjs(date, 'DD.MM.YYYY HH:mm').format(format)
    }
    return dayjs(date).format(format)
  }

  const formatDuration = (duration: number) => {
    return dayjs.duration(duration, 'minutes').format('H:mm')
  }

  return { collectField, formatDate, durationUntilNow, formatDuration }
}
