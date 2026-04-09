@props(['type' => 'success'])

@php
    $colors = [
        'success' => ['bg' => '#dcfce7', 'text' => '#166534'],
        'danger' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
        'warning' => ['bg' => '#fef3c7', 'text' => '#92400e'],
        'info' => ['bg' => '#e0f2fe', 'text' => '#075985'],
    ];
    $color = $colors[$type] ?? $colors['success'];
@endphp

<span {{ $attributes->merge(['class' => 'badge']) }} style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
    {{ $slot }}
</span>
