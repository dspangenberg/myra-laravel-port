import dayjs from 'dayjs'
import duration from 'dayjs/plugin/duration'
import relativeTime from 'dayjs/plugin/relativeTime'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import numbro from 'numbro'

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
    if (date?.length > 16) {
      locale = 'en'
    }
    if (locale === 'de') {
      return dayjs(date, 'DD.MM.YYYY HH:mm').format(format)
    }
    return dayjs(date).format(format)
  }
  const formatSumDuration = (duration: number) => {
    const dayJSduration = dayjs.duration(duration, 'minute')
    const nbHours = dayJSduration.days() * 24 + dayJSduration.hours()
    const nbMinutes = dayJSduration.minutes()
    const minutes = numbro(nbMinutes).format('00')
    return `${nbHours}:${minutes}`
  }

  const formatDuration = (duration: number) => {
    return dayjs.duration(duration, 'minutes').format('H:mm')
  }

  return { collectField, formatDate, durationUntilNow, formatDuration, formatSumDuration }
}
