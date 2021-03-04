<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('static/css/app.css') }}" />

    <title>{{env('APP_NAME')}}</title>
</head>
<body>
<div id="app">
    <v-app>
        <v-main>
            @include('navigation')

            @yield('content')
        </v-main>
    </v-app>
</div>

<script src="{{ mix('static/js/app.js') }}"></script>
</body>
</html>
