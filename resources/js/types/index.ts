export interface IKeyValueStore {
  [key: string]: string
}

export interface IKeyValueMulitTypeStore {
  [key: string]: number | string | boolean | undefined | null
}
export interface Setting {
  key: string
  value: string
  type: string
}

export type TypedArray = Int8Array | Uint8Array | Uint8ClampedArray | Int16Array | Uint16Array | Int32Array | Uint32Array | Float32Array | Float64Array;

export type FormData = Record<string, unknown>

export interface parentInterval {
  interval: number,
  numberOfIntervals: number,
}
export interface Meta {
  from: number,
  to: number
  current_page: number,
  per_page: number,
  last_page: number,
  path: string,
  total: number
}

export interface Option {
  id: number
  name: string
  disabled?: boolean
  group?: string
}

export interface PdfResponse {
  dataUrl: string
  base64: string
}

export interface ParamsLayoutNavigationSubItem {
    label: string
    disabled: boolean
    route: string
    name: string
    activeRoute: string
    title: string
    recordName: string
    addButtonTitle: string
    addButtonRoute: string
    firstButtonTitle: string
    seperator?: boolean
  }

export interface ParamsLayoutNavigationItem {
    label: string
    icon: string
    name: string
    disabled: boolean
    route: string
    activeRoute: string
    items: ParamsLayoutNavigationSubItem[]
  }
