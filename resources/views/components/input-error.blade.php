@props(['messages'])

@if ($messages)
    <ul {{ $attributes->class(['mt-2', 'text-sm', 'text-red-600']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
