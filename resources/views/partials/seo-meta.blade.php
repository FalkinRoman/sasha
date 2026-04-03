@php
    $siteName = config('prostoy.site_name', 'PROSTO.YOGA');
    $pageTitle = isset($pageTitle) && $pageTitle !== '' ? strip_tags($pageTitle) : $siteName.' — онлайн-курс йоги';
    $description = isset($metaDescription) && $metaDescription !== ''
        ? strip_tags($metaDescription)
        : config('prostoy.meta_description');
    $canonical = isset($canonicalOverride) && $canonicalOverride !== ''
        ? $canonicalOverride
        : url()->current();
    $ogImageRel = config('prostoy.og_image', 'images/figma/decstop.webp');
    $ogImage = preg_match('#^https?://#', $ogImageRel) ? $ogImageRel : asset($ogImageRel);
    $ogW = (int) config('prostoy.og_image_width', 1920);
    $ogH = (int) config('prostoy.og_image_height', 1080);
@endphp
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
@if ($ogW > 0)
<meta property="og:image:width" content="{{ $ogW }}">
@endif
@if ($ogH > 0)
<meta property="og:image:height" content="{{ $ogH }}">
@endif
<meta property="og:locale" content="ru_RU">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<meta name="theme-color" content="#869274">
