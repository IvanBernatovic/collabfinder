<div>
    <div>
        <div class="py-6 flex">
            <div class="bg-gray-300 relative flex-grow line"></div>
            <div class="px-5 text-gray-600">Or {{ $action ?? 'sign in' }} with</div>
            <div class="bg-gray-300 relative flex-grow line"></div>
        </div>

    </div>
    <div class="-mx-1 flex items-center justify-center">
        @foreach ([['name' => 'google', 'class' => 'text-blue-700'], ['name' => 'twitter', 'class' => 'text-blue-400'], ['name' => 'github', 'class' => '']] as $service)
            <a class="border rounded px-3 py-2 mx-1 w-16 text-center"
                href="{{ route('social-login', ['service' => $service['name']]) }}"><i
                    class="fab fa-{{ $service['name'] }} {{ $service['class'] }}"></i></a>
        @endforeach
    </div>
</div>
