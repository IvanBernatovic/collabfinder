export const removeFalsy = obj =>
  Object.keys(obj).reduce((returnObj, currentKey) => {
    if (obj[currentKey]) {
      returnObj[currentKey] = obj[currentKey]
    }

    return returnObj
  }, {})
