<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php
        $__pvSeoTitle = trim($__env->yieldContent('title'));
        $__pvSeoDesc = trim($__env->yieldContent('meta_description'));
        $__pvSeoCanon = trim($__env->yieldContent('canonical'));
    @endphp
    @include('partials.seo-meta', [
        'pageTitle' => $__pvSeoTitle,
        'metaDescription' => $__pvSeoDesc,
        'canonicalOverride' => $__pvSeoCanon,
    ])
    <title>@yield('title', 'ProstoYoga — современная йога онлайн')</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('brand/favicon-white-bg.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[#2d312d] antialiased">
    @yield('content')
    @if ($errors->any())
        <script type="application/json" id="pv-page-errors">@json($errors->messages())</script>
    @endif
</body>
</html>
