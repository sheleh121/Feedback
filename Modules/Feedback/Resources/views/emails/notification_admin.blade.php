<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Feedback</title>

{{-- Laravel Mix - CSS File --}}
{{-- <link rel="stylesheet" href="{{ mix('css/feedback.css') }}"> --}}

</head>
<body>
<div class="container">
    <h3>Получено новое сообщение</h3>
    <h5>
        Отправитель: {{$user_name}} {{$email}}
    </h5>
    <p>
        {{$body}}
    </p>
</div>

{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/feedback.js') }}"></script> --}}
</body>
</html>