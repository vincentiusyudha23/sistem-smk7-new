<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary mb-3 text-white text-lg w-full']) }}>
    {{ $slot }}
</button>
