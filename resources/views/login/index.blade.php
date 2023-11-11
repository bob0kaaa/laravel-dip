@extends('layouts.base')

@section('page.title', 'Страница авторизации')


@section('content')
    <span class="page-header__subtitle">Администраторррская</span>

    <x-card>
       <x-card-header>
           <h2 class="login__title">{{ __('Авторизация') }}</h2>
       </x-card-header>

        <x-card-body>
            <x-form class="login__form" action="{{ route('login.store') }}" method="POST" accept-charset="utf-8">
                <x-form-item class="login__label" for="email">
                    {{ __(' E-mail') }}
                    <x-input type="email" placeholder="example@domain.xyz" name="email" required autofocus/>
                </x-form-item>
                <x-form-item class="login__label" for="password">
                    {{ __(' Пароль') }}
                    <x-input type="password" placeholder="" name="password" required />
                </x-form-item>
                <x-form-button class="text-center">
                    <x-button type="submit">
                        {{ __('Авторизоваться') }}
                    </x-button>
                </x-form-button>
            </x-form>
        </x-card-body>
    </x-card>
@endsection
