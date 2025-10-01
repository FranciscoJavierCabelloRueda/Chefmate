@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => '',
    'required' => false,
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="{{ old($name, $value) }}"
    @if($required) required @endif
/>