@props([
    'messages' => [],
])

@if (!empty($messages))
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 mt-1']) }}>
        @foreach ($messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

