<template>
            <v-menu
                v-model="open"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        :label=title
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        :rules=rules
                        :error-messages="errors"
                    ></v-text-field>
                </template>
                <v-date-picker
                    v-model="date"
                    locale="ru-ru"
                    :min=nowDate
                    @input="open = false"
                ></v-date-picker>
            </v-menu>
</template>

<script>
    export default {
        data () {
            return {
                date: null,
                nowDate: new Date().toISOString().slice(0,10),
                open: false,
                rules: [
                    value => !!value || "Обязательно для заполнения",
                ]
            }
        },
        props:["title", "value", "errors"],
        created(){
            this.date = this.value;
        },
        methods: {
            update() {
                this.$value = this.date;
                this.$emit('input', this.date);
            }
        },
        watch: {
            date (val) {
                this.update();
            }
        }
    }
</script>
