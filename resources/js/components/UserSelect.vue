<template>
    <v-select
        v-model="user"
        :hint="`${user.name}, ${user.balance}`"
        :items=users
        item-text="name"
        item-value="id"
        :label=title
        persistent-hint
        return-object
        single-line
        :rules=rules
        required
        @change="update"
        :error-messages="errors"
    ></v-select>
</template>

<script>
    import {getters as userGetters} from "../stores/user"

    export default {
        data () {
            return {
                user: {
                    name: null,
                    id: null,
                    balance: null
                },
                rules: [
                    value => !value || "Обязательно для заполнения",
                ]
            }
        },
        props:["title", "value", "errors"],
        computed: {
            users: userGetters.users
        },
        methods: {
            update() {
                this.$value = this.user;
                this.$emit('input', this.user);
            },
            required(value) {
                if (value instanceof Array && value.length == 0) {
                    return 'Required.';
                }
                return !!value || 'Required.';
            },
        }
    }
</script>
