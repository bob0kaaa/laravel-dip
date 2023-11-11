<button {{ $attributes->merge([
    'type'=>'button',
    'class'=>'login__button'
]) }}>
    {{ $slot }}
</button>
