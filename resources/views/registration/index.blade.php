@extends('layouts.base')

@section('page.title', 'Страница Регистрации')


@section('content')
    <span class="page-header__subtitle">Администраторррская</span>

    <x-card>
        <x-card-header>
            <h2 class="login__title">{{ __('Регистрация') }}</h2>
        </x-card-header>

        <x-card-body>
            <x-form class="login__form" action="{{ route('registration.store') }}" method="POST" accept-charset="utf-8">
                <x-form-item class="login__label" for="email">
                    {{ __(' Имя') }}
                    <x-input placeholder="Иванов Иван" name="name" required autofocus/>
                </x-form-item>
                <x-form-item class="login__label" for="email">
                    {{ __(' E-email') }}
                    <x-input type="eemail" placeholder="example@domain.xyz" name="email" required/>
                </x-form-item>
                <x-form-item class="login__label" for="password">
                    {{ __(' Пароль') }}
                    <x-input type="password" placeholder="" name="password" required/>
                </x-form-item>
                <x-form-item class="login__label" for="password">
                    {{ __(' Пароль еще раз') }}
                    <x-input type="password" placeholder="" name="password_confirmation" required/>
                </x-form-item>
                <x-form-button class="text-center">
                    <x-button type="submit">
                        {{ __('Зарегистрироваться') }}
                    </x-button>
                </x-form-button>
            </x-form>
        </x-card-body>
    </x-card>
@endsection
