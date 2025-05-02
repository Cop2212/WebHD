@props([
    'title' => null,
    'description' => null,
    'icon' => null
])

<div {{ $attributes->merge(['class' => 'text-center py-12']) }}>
    @if($icon)
        <div class="mx-auto h-12 w-12 text-gray-400">
            {{ $icon }}
        </div>
    @endif

    @if($title)
        <h3 class="mt-2 text-lg font-medium text-gray-900">
            {{ $title }}
        </h3>
    @endif

    @if($description)
        <p class="mt-1 text-sm text-gray-500">
            {{ $description }}
        </p>
    @endif

    {{ $slot }}
</div>
