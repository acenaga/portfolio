@props(['name', 'size' => 20, 'class' => ''])

@switch($name)
    @case('arrow-up-right')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 17 17 7"></path>
            <path d="M9 7h8v8"></path>
        </svg>
        @break
    @case('arrow-right')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
        </svg>
        @break
    @case('play')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="m8 5 11 7-11 7z"></path>
        </svg>
        @break
    @case('eye')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        @break
    @case('heart')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 21s-7.2-4.7-9.4-8.8C1 9.3 2.4 5.8 6.1 5.1c2-.4 3.9.5 4.9 2 1-1.5 2.9-2.4 4.9-2 3.7.7 5.1 4.2 3.5 7.1C19.2 16.3 12 21 12 21Z"></path>
        </svg>
        @break
    @case('comment')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"></path>
        </svg>
        @break
    @case('sparkles')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 3 1.9 4.1L18 9l-4.1 1.9L12 15l-1.9-4.1L6 9l4.1-1.9z"></path>
            <path d="M5 19v-2"></path>
            <path d="M5 23v-2"></path>
            <path d="M3 21h2"></path>
            <path d="M7 21H5"></path>
        </svg>
        @break
    @case('clock')
        <svg {{ $attributes->merge(['class' => $class]) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9"></circle>
            <path d="M12 7v5l3 2"></path>
        </svg>
        @break
    @case('youtube')
        <span {{ $attributes->merge(['class' => $class]) }}>▶</span>
        @break
    @case('instagram')
        <span {{ $attributes->merge(['class' => $class]) }}>◎</span>
        @break
    @case('twitch')
        <span {{ $attributes->merge(['class' => $class]) }}>◫</span>
        @break
    @case('kick')
        <span {{ $attributes->merge(['class' => $class]) }}>K</span>
        @break
    @case('x')
        <span {{ $attributes->merge(['class' => $class]) }}>X</span>
        @break
    @case('threads')
        <span {{ $attributes->merge(['class' => $class]) }}>@</span>
        @break
    @default
        <span {{ $attributes->merge(['class' => $class]) }}>•</span>
@endswitch
