@extends('layouts.base')

@section('content')
    <span class="page-header__subtitle">{{ __('Администраторррская') }}</span>
    @if(session('status'))
        <div class="conf-step__paragraph c">
            {{session('status')}}
        </div>
    @endif
    <section id="creatHall" class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">{{ __('Управление залами') }}</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">{{ __('Доступные залы:') }}</p>

            <ul class="conf-step__list">
                @foreach($halls as $hall)
                    <li>
                        {{ $hall->name }}
                        @include('admin.delete', ['hall'=> $hall])
                        <a id="{{$hall->id}}" onclick="popupToggle(id)" style="display: inline-block;" href="#" class="conf-step__button conf-step__button-trash"></a>
                    </li>

                @endforeach
            </ul>
            <button id="openModal" class="conf-step__button conf-step__button-accent">{{ __('Создать зал') }}</button>
        </div>
        @include('admin.add_hall')

        <script>

                let section = document.querySelector('#creatHall');
                let openButton = section.querySelector('#openModal');
                let popupCreate = section.querySelector('#popupCreatHall');
                    openButton.addEventListener('click', () => {
                        popupCreate.classList.add("active");
                        console.log('123')
                });

                    function popupToggle(id){
                        let elem = 'popup' + `${id}`;
                        console.log(elem)
                        let popup = document.getElementById(elem);
                        popup.classList.add("active");
                    }



        </script>

    </section>
@endsection

