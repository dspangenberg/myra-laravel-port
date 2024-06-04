import axios, { type Axios, AxiosError, type AxiosResponse, type AxiosRequestConfig } from 'axios'
import queryString from 'query-string'
import { base64ToUint8Array } from 'uint8array-extras'

export interface IAxiosHelpers extends Axios {
  axios: Axios
  setHeader(property: string, data: string | number): void
  setToken(token: string, type: string | null): void
  setBaseURL(baseUrl: string): void
  $post<T = any, R = AxiosResponse<T>, D = any>(url: string, data?: D, config?: AxiosRequestConfig<D>): Promise<R>;
  $get<T = any, R = AxiosResponse<T>, D = any>(url: string, data?: D, config?: AxiosRequestConfig<D>): Promise<R>;
  $getBase64<T = any, R = AxiosResponse<T>, D = any>(url: string, data?: D, config?: AxiosRequestConfig<D>): Promise<R>;
  $delete<T = any, R = AxiosResponse<T>, D = any>(url: string, config?: AxiosRequestConfig<D>): Promise<R>;
  $put<T = any, R = AxiosResponse<T>, D = any>(url: string, data?: D, config?: AxiosRequestConfig<D>): Promise<R>;
  $patch<T = any, R = AxiosResponse<T>, D = any>(url: string, data?: D, config?: AxiosRequestConfig<D>): Promise<R>;
  blobToDataUri(blob: Blob): Promise<string>
}

const setHeader = (axios: Axios) => (property: string, data: string | number) => {
  axios.defaults.headers.common[property] = data
}

const setBaseURL = (axios: Axios) => (baseURL: string) => {
  axios.defaults.baseURL = baseURL
}

const setToken =
  (axios: Axios) =>
    (token: string, type: string | null = null) => {
      switch (type) {
        case 'Bearer': {
          return (axios.defaults.headers.common.Authorization = `Bearer ${token}`)
        }
        default: {
          return (axios.defaults.headers.common.Authorization = token)
        }
      }
    }

const axiosHelpers = (_axios: Axios): IAxiosHelpers => {
  const $axios = _axios as IAxiosHelpers

  const getError = (error: Error | AxiosError) => {
    if (axios.isAxiosError(error)) {
      return error.response?.data as AxiosError
    }
    return error as Error
  }

  $axios.setHeader = setHeader(axios)
  $axios.setBaseURL = setBaseURL(axios)
  $axios.setToken = setToken(axios)

  $axios.$delete = async (url, config) => {
    try {
      const response: AxiosResponse = await axios.delete(url, config)
      return Promise.resolve(response.data)
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  $axios.$get = async (url, params, config) => {
    $axios.setHeader('accept', 'application/json')

    if (params) {
      const qs = queryString.stringify(params)
      if (qs) {
        url = `${url}?${qs}`
      }
    }

    try {
      const response: AxiosResponse = await axios.get(url, config)
      return Promise.resolve(response.data)
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  $axios.blobToDataUri = (blob): Promise<string> => {
    return new Promise<string>((resolve, reject) => {
      const reader = new FileReader()
      // eslint-disable-next-line @typescript-eslint/no-unused-vars
      reader.onload = _e => resolve(reader.result as string)
      // eslint-disable-next-line @typescript-eslint/no-unused-vars
      reader.onerror = _e => reject(reader.error)
      // eslint-disable-next-line @typescript-eslint/no-unused-vars
      reader.onabort = _e => reject(new Error('Read aborted'))
      reader.readAsDataURL(blob)
    })
  }

  $axios.$getBase64 = async (url, params, config) => {
    $axios.setHeader('accept', 'application/pdf')

    const realConfig: AxiosRequestConfig = {
      ...config,
      responseEncoding: 'blob'
    }

    if (params) {
      const qs = queryString.stringify(params)
      if (qs) {
        url = `${url}?${qs}`
      }
    }

    try {
      const response: AxiosResponse = await axios.get(url, realConfig)

      const array = base64ToUint8Array(response.data)
      const blob = new Blob([array], { type: 'application/pdf' })
      const dataUrl = await $axios.blobToDataUri(blob)
      return Promise.resolve({ dataUrl, base64: response.data })
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  $axios.$post = async (url, data, config) => {
    try {
      const response: AxiosResponse = await axios.post(url, data, config)
      return Promise.resolve(response.data)
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  $axios.$patch = async (url, data, config) => {
    try {
      const response: AxiosResponse = await axios.patch(url, data, config)
      return Promise.resolve(response.data)
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  $axios.$put = async (url, data, config) => {
    try {
      const response: AxiosResponse = await axios.patch(url, data, config)
      return Promise.resolve(response.data)
    } catch (error) {
      return Promise.reject(getError(error as Error | AxiosError))
    }
  }

  return $axios
}

export { axiosHelpers }
