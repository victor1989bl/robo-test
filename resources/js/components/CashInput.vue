<template>
    <v-text-field
        :label=title
        :rules="rules"
        hide-details="auto"
        type="number"
        v-bind:value="value"
        v-on:input="$emit('input', $event)"
        :error-messages="errors"
    ></v-text-field>
</template>

<script>

    export default {
        data () {
            return {
                rules: [
                    value => !!value || 'Обязательно для заполнения',
                    value => value > 0 || 'Укажите значение больше 0',
                ]
            }
        },
        props:["title",  "value", "errors"]
    }
</script>
