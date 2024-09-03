<a {{ $attributes->merge(['class' => 'text-white font-medium rounded-full text-sm px-5 py-2.5 text-center']) }}>
    <button type="button" class="w-full h-full">
        {{ $slot }}
    </button>
</a>
