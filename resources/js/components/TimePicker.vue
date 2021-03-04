<template>
    <v-text-field
        label="Время"
        hide-details="auto"
        type="time"
        :value="`${nextHour > 23 ? 23 : nextHour}:00`"
        :min="`${nextHour > 23 ? 23 : nextHour}:00`"
        step="3600000"
        v-bind:value="value"
        v-on:input="$emit('input', $event)"
        :rules=rules
    ></v-text-field>
</template>

<script>
    export default {
        data () {
            return {
                nowDate: new Date().toISOString().slice(0,10),
                nextHour: new Date().getHours() + 1,
                rules: [
                    value => !!value || "Обязательно для заполнения",
                ]
            }
        },
        props:["title", "value"]
    }
</script>
