import Vue from "vue";
import ApiService from "../services/api.service";

const state = Vue.observable({
    users: []
});

export const getters = {
    users: () => state.users
};

export const mutations = {
    setUsers: value => (state.users = value.data),
};

export const actions = {
    fetchUsers() {
        ApiService.get("/api/users").then(response => {
            mutations.setUsers(response.data);
        });
    }
};
