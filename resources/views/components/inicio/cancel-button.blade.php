<a {{ $attributes->merge(['type' => 'submit', 'class' => 'btn cursor-pointer bg-gray-200 text-black block w-full text-center hover:bg-gray-300']) }}>
    {{ $slot }}
</a>
