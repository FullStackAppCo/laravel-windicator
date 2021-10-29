@props(['env' => 'local', 'label' => null])
@php
    $env = \Illuminate\Support\Arr::wrap($env);
    $breakpoints = [
        'all' => 'sm:hidden',
        'sm' => 'hidden sm:flex md:hidden',
        'md' => 'hidden md:flex lg:hidden',
        'lg' => 'hidden lg:flex xl:hidden',
        'xl' => 'hidden xl:flex 2xl:hidden',
        '2xl' => 'hidden 2xl:flex',
    ];
@endphp
@env ($env)
    @if (app('env') === 'local' || optional(app('auth')->user())->can('view-windicator'))
        <div
            data-windicator
            {{$attributes->merge([
                'class' => "w-full flex items-stretch justify-center font-bold uppercase z-50 tracking-wider bg-yellow-500 text-gray-900",
                'style' => 'font-size: .6rem',
            ])}}
        >
            <p class="flex items-center px-6 leading-none">{{ $label ?? app('env') }}</p>
            <div class="flex-grow">
                @foreach($breakpoints as $breakpoint => $classes)
                    <p class="py-2 flex items-center justify-center {{ $classes }}">
                        <x-dynamic-component :component="'windicator::icon.' . $breakpoint" class="w-4 h-4 mr-1" />
                        <span class="leading-tight">{{ $breakpoint }}</span>
                    </p>
                @endforeach
            </div>
            <button
                    data-windicator-close
                    class="font-semibold focus:bg-gray-900 focus:text-yellow-500 outline-none px-6 bg-yellow-600  cursor-pointer uppercase tracking-wide"
            >Close</button>
            <script>
              (function(){
                const node = document.querySelector('[data-windicator]');
                const clone = node.cloneNode(true);
                clone.classList.add('fixed', 'top-0', 'left-0');
                node.appendChild(clone);

                window.windicator = function(show) {
                  let method = 'toggle';

                  if (show !== undefined) {
                    method = show === true ? 'remove' : 'add';
                  }

                  [node, clone].forEach(el => el.classList[method]('hidden'));
                  return (function(state) {
                    localStorage.setItem('windicator:show', state);
                    return state;
                  })(!node.classList.contains('hidden'));
                }

                window.windicator(JSON.parse(localStorage.getItem('windicator:show')) ?? true);

                function addListener() {
                  [].slice.call(arguments).forEach(el => {
                    el.querySelector('[data-windicator-close]').addEventListener('click', clickHandler);
                  });
                }

                function clickHandler(evt) {
                  evt.stopPropagation();
                  evt.preventDefault();
                  window.windicator(false);
                }

                addListener(node, clone);
              })();
            </script>
        </div>
    @endif
@endenv
