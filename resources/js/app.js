import Vue from "vue";
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import {actions} from './stores/user'

import ApiService from "./services/api.service";

import UserSelect from "./components/UserSelect";
import CashInput from "./components/CashInput";
import DatePicker from "./components/DatePicker";
import TimePicker from "./components/TimePicker";

import NavigationMenu from "./components/NavigationMenu";

Vue.use(Vuetify);

new Vue({
    el: "#app",
    vuetify : new Vuetify(),
    mounted(){
        actions.fetchUsers();
    },
    data: {
        payer: null,
        recipient: null,
        cash: null,
        payDate: null,
        payTime: null,
        loading: false,

        errors: ''
    },
    methods: {
        canPay(){
            this.$refs.form.validate();

            return !!this.payer
                && !!this.recipient
                && !!this.cash
                && !!this.payDate
                && !!this.payTime;
        },
        submitPaymentForm(event) {
            event.preventDefault();

            this.$refs.form.resetValidation();

            if(!this.canPay()){
                // return false;
            }

            this.loading = true;

            const {
                payer,
                recipient,
                cash,
                payDate,
                payTime
            } = this;

            ApiService.post("/api/payment", {
                payerId: payer ? payer.id : null,
                recipientId: recipient ? recipient.id : null,
                cash: cash,
                payDateTime: (payDate && payTime) ? `${payDate} ${payTime}` : null
            }).then(responce => {
                this.$refs.form.reset();
                this.loading = false;
            }).catch(error => {
                this.errors = error.response.data.errors;
                this.loading = false;
            })
        }
    },
    components: {
        UserSelect,
        CashInput,
        DatePicker,
        TimePicker,
        NavigationMenu,
    }
});
