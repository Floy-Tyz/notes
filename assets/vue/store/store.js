import {createStore} from "vuex";
import state from './todo/state'
import * as getters from "@/store/todo/getters";
import mutations from "@/store/todo/mutations";

const store = createStore({
    state,
    getters,
    mutations
})

export default store