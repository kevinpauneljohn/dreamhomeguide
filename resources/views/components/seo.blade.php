<!-- Required Meta Tags -->
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Primary SEO -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="Dream Home Guide Realty">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">

<!-- Canonical -->
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph -->
<meta property="og:locale" content="en_PH">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:site_name" content="Dream Home Guide Realty">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<!-- Schema (JSON-LD Dynamic) -->
@php
    $schema = [
        "@context" => "https://schema.org",
        "@type" => $schemaType,
        "name" => $title,
        "description" => $description,
        "url" => $canonical,
        "image" => $image,
        "publisher" => [
            "@type" => "Organization",
            "name" => "John Kevin Paunel",
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('/images/logo.png')
            ]
        ]
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>



