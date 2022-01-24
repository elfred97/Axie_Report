import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        global_guard_type    : global_guard_type,
        global_guard_username: global_guard_username,
        global_guard_role    : global_guard_role,
    },
});