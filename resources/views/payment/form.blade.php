@extends('layout')

@section('content')
    <v-container>
        <v-row justify="space-between">
            <v-col cols="12" md="4">
                <v-form ref="form" @submit="submitPaymentForm">
                    <user-select
                        title="Отправитель"
                        v-model="payer"
                        :errors="errors.payerId"
                    ></user-select>

                    <user-select
                        title="Получатель"
                        v-model="recipient"
                        :errors="errors.recipientId"
                    ></user-select>

                    <cash-input
                        title="Сумма"
                        v-model="cash"
                        :errors="errors.cash"
                    ></cash-input>

                    <v-row>
                        <v-col cols="12" sm="6">
                            <date-picker
                                title="Дата и время проведеия операции"
                                v-model="payDate"
                                :errors="errors.payDateTime"
                            ></date-picker>
                        </v-col>

                        <v-col cols="12" sm="6">
                            <time-picker
                                v-model="payTime"
                            ></time-picker>
                        </v-col>
                    </v-row>

                    <v-btn class="mr-4" type="submit" :loading="loading">Отправить</v-btn>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
@endsection
