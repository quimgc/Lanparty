import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import users from '../../../api/users'

export default {
  [ actions.SELECTED_USER ] (context, user) {
    context.commit(mutations.SELECTED_USER, user)
  },
  [ actions.FETCH_USERS ] (context) {
    return new Promise((resolve, reject) => {
      users.fetch().then(response => {
        console.log(response)
        console.log(response.data)
        context.commit(mutations.SET_USERS, response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
