import {createStore} from "vuex";
import state from './todo/state'
import getters from "./todo/getters";
import mutations from "./todo/mutations";
import actions from "./todo/actions";

const store = createStore({
    state,
    getters,
    mutations,
    actions
})

export default store