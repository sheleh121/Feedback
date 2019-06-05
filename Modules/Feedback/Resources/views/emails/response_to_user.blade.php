<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            .line {
                border-left: 2px solid #ccc; /* Параметры линии */
                margin-left: 20px; /* Отступ слева */
                padding-left: 10px; /* Расстояние от линии до текста */
            }
        </style>
    </head>
<body>

<div class="container">
    <p>
        {{$answer}}
    </p>
    <p class="line">
        {{$source_message->body}}
    </p>
</div>

</body>
</html>

