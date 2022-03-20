import { usePage } from '@inertiajs/inertia-vue3'
import produce from 'immer'
import { shallowRef } from 'vue'

export const removeFalsy = obj =>
  Object.keys(obj).reduce((returnObj, currentKey) => {
    if (obj[currentKey]) {
      returnObj[currentKey] = obj[currentKey]
    }

    return returnObj
  }, {})

export function useImmer(baseState) {
  const state = shallowRef(baseState)
  const update = updater => {
    state.value = produce(state.value, updater)
  }

  return [state, update]
}

export const useUser = () => usePage().props.value.user

export const useParams = () => {
  const url = new URL(window.location)

  return Object.fromEntries(url.searchParams)
}

export const goBack = () => window.history.back()
