@props([
    'title'       => 'Mandorin — Platform Digital Konstruksi Indonesia',
    'description' => 'Temukan kontraktor & mandor terpercaya, kelola proyek, dan pantau progres harian secara transparan bersama Mandorin.',
    'ogImage'     => null,
    'canonical'   => null,
])
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical ?? url()->current() }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
<meta property="og:site_name" content="Mandorin">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
