@props([
    'color' => 'blue',
    'href' => null,
    'wireNavigate' => false
])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-800',
        'red' => 'bg-red-100 text-red-800',
        'green' => 'bg-green-100 text-green-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'indigo' => 'bg-indigo-100 text-indigo-800',
        'gray' => 'bg-gray-100 text-gray-800',
    ];
@endphp

@if($href)
    <a {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $colors[$color]]) }}
       @if($wireNavigate) wire:navigate @endif
       href="{{ $href }}">
        {{ $slot }}
    </a>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $colors[$color]]) }}>
        {{ $slot }}
    </span>
@endif
