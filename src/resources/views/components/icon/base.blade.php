<svg {{ $attributes->merge([
    'aria-hidden' => true,
    'focusable' => true,
    'role' => 'img',
    'xmlns' => 'http://www.w3.org/2000/svg',
    'class' => 'fill-current'
    ]) }}>{{ $slot }}</svg>
