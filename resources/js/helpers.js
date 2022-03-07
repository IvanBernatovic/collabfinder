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
