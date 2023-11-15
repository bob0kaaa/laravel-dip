@extends('layouts.base')

@section('content')
    <span class="page-header__subtitle">{{ __('Администраторррская') }}</span>
    @if(session('status'))
        <div class="conf-step__paragraph">
            {{session('status')}}
        </div>
    @endif
    <section id="creatHall" class="conf-step">
        <header class="conf-step__header conf-step__header_closed">
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
                        let popup = document.getElementById(elem);
                        popup.classList.add("active");
                    }
        </script>
    </section>
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">{{ __('Конфигурация залов') }}</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">{{ __('Выберите зал для конфигурации:') }}</p>
            <ul class="conf-step__selectors-box">
                @foreach($halls as $hall)
                    <li>
                        @if($hall->{'id'} == $selected_hall)
                            <input type="radio" id="{{ $hall->id }}" data-rows="{{ $hall->row }}" data-cols="{{ $hall->col }}" onclick="radioInput(id)" class="conf-step__radio" name="{{ $hall->id }}" value="{{ $hall->name }}" checked>
                            <span class="conf-step__selector">{{ $hall->name }}</span>
                        @else
                            <input type="radio" id="{{ $hall->id }}" data-rows="{{ $hall->row }}" data-cols="{{ $hall->col }}" onclick="radioInput(id)" class="conf-step__radio" name="{{ $hall->id }}" value="{{ $hall->name }}">
                            <span class="conf-step__selector">{{ $hall->name }}</span>
                        @endif

                    </li>
                @endforeach

            </ul>
            <p class="conf-step__paragraph">{{ __('Укажите количество рядов и максимальное количество кресел в ряду:') }}</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">{{ __('Рядов') }}, {{ __('шт') }}<input id="rowsHall" type="text" class="conf-step__input" value="{{ $halls->where('id', $selected_hall)->first()->row }}"></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">{{ __('Мест') }}, {{ __('шт') }}<input id="colsHall" type="text" class="conf-step__input" value="{{ $halls->where('id', $selected_hall)->first()->col }}"></label>
            </div>
            <p class="conf-step__paragraph">{{ __('Теперь вы можете указать типы кресел на схеме зала:') }}</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — {{ __('обычные кресла') }}
                <span class="conf-step__chair conf-step__chair_vip"></span> — {{ __('VIP кресла') }}
                <span class="conf-step__chair conf-step__chair_disabled"></span> — {{ __('заблокированные (нет кресла)') }}
                <p class="conf-step__hint">{{ __('Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши') }}</p>
            </div>

            <x-admin.buttons :hall="$halls->where('id',$selected_hall)->first()" :selected_hall="$selected_hall" />
        </div>
        <script>
            function radioInput(id){
                let url = "{{ route('admin.index',['selected_hall' => 'id']) }}";
                id = String(id);
                url = url.replace('id', id);
                window.location.href= url
            }

            function select(id){
                let place = document.getElementById(id)
                let typePlace = place.dataset.type;
                let typeNext;
                let types = ['NORM', 'VIP', "FAIL"]
                let countTypes = types.length;
                let typeCurrent = types.indexOf(place.dataset.type);
                for (let i = 0; i < types.length; i++) {
                    let type = types[i];
                    if(type === typePlace){
                        typeNext = typeCurrent + 1;
                        if (typeNext === countTypes) {
                            typeNext = 0;
                        }
                        place.setAttribute("data-type", types[typeNext]);
                        if(document.getElementById(id).dataset.type === 'VIP') {
                            place.classList.add('conf-step__chair_vip')
                            place.classList.remove('conf-step__chair_disabled')
                            place.classList.remove('conf-step__chair_standart')
                        } else if (document.getElementById(id).dataset.type === 'NORM') {
                            place.classList.remove('conf-step__chair_vip')
                            place.classList.remove('conf-step__chair_disabled')
                            place.classList.add('conf-step__chair_standart')
                        } else if (document.getElementById(id).dataset.type === 'FAIL') {
                            place.classList.remove('conf-step__chair_vip')
                            place.classList.add('conf-step__chair_disabled')
                            place.classList.remove('conf-step__chair_standart')
                        }
                    }
                }
            }
            function editSeat(id) {
                let newTypesHall = [];
                let btnList = document.querySelector('.conf-step__hall-wrapper');
                let btnsPlace = btnList.querySelectorAll('.conf-step__chair');
                for (let i = 0; i < btnsPlace.length; i++) {
                    let button = btnsPlace[i];
                    let newTypes = {};

                    newTypes.key = button.id;
                    newTypes.value = button.dataset.type;
                    newTypesHall.push(newTypes);
                }
                let json_string = JSON.stringify(newTypesHall);
                let url = "{{ route('admin.editHall', ['hall'=> $halls->where('id', $selected_hall)->first(), 'newTypeHall' => 'json_string']) }}"
                url = url.replace('json_string', json_string);
                url = url.replaceAll('&amp;', '&');
                console.log(url)
                window.location.href = url;
            }
        </script>
    </section>
@endsection

