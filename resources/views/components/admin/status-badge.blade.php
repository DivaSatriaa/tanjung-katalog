@props(['status'])

@if ($status === 'published')
    <span {{ $attributes->merge(['class' => 'inline-flex shrink-0 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700']) }}>Terbit</span>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex shrink-0 rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-medium text-yellow-700']) }}>Draf</span>
@endif
