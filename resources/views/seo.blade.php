<base href="{{ url('/') }}" />
<title inertia>{{ $j_inertia_meta['title'] }}</title>
<meta name="description" content="{{ $j_inertia_meta['description'] }}" />
<meta name="keywords" content="{{ config('j_option_autoload.meta_keywords') }}" />
<meta name="author" content="{{ config('j_option_autoload.site_name') }}" />
<!-- openGraph -->
<meta property="og:title" content="{{ $j_inertia_meta['title'] }}" />
<meta property="og:description" content="{{ $j_inertia_meta['description'] }}" />
<meta property="og:type" content="{{ $j_inertia_meta['type'] ?? 'website' }}" />
<meta property="og:url" content="{{ $j_inertia_meta['url'] }}" />
<meta property="og:image"
    content="{{ $j_inertia_meta['image'] ?? url('/storage/' . config('j_option_autoload.icon')) }}" />
<!-- twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $j_inertia_meta['title'] }}" />
<meta name="twitter:description" content="{{ $j_inertia_meta['description'] }}" />
<meta name="twitter:image"
    content="{{ $j_inertia_meta['image'] ?? url('/storage/' . config('j_option_autoload.icon')) }}" />
