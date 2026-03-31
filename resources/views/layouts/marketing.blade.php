<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PROSTO.YOGA — онлайн-программа: 12 практик, 3 раза в неделю. Результат за 30 дней: осанка, тело, энергия. Тарифы от 2900 ₽.">
    <title>@yield('title', 'ProstoYoga — современная йога онлайн')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[#2d312d] antialiased">
    @yield('content')
</body>
</html>
