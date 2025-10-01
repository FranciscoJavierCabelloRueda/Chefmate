@props([
    'for',
    'value' => null,
])

<label for="{{ $for }}">
    {{ $value ?? $slot }}
</label>
