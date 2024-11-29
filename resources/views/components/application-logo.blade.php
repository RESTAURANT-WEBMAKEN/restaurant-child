@props(['logoUrl' => \App\CentralLogics\Helpers::appLogo(), 'title' => \App\CentralLogics\Helpers::appName()])

<img
    {{ $attributes->merge([
        'class' => 'h-full w-full',
        'src' => $logoUrl,
        'alt' => $title . ' Official Logo',
    ]) }}>
