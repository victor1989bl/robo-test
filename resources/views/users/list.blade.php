@extends('layout')

@section('content')
    <v-container>
        <v-row justify="space-between">
            <v-col cols="12" md="12">
                <table>
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Баланс</th>
                            <th>Последний перевод</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->metadata->balance }}</td>
                            <td>
                                @if (!empty($user->latestPayment))
                                {{ $user->latestPayment->cash ?? null }}
                                {{ $user->latestPayment->recipient->name ?? null }}
                                {{ $user->latestPayment->status_date->format('d.m.Y H:i') ?? null }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>


                </table>

            </v-col>
        </v-row>
    </v-container>
@endsection
