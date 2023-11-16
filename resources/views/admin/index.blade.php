@extends('layouts.base')
@php
    $selected_hall = (int)$selected_hall;
@endphp
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
                });
                function popupToggle(id){
                    let elem = 'popup' + `${id}`;
                    let popup = document.getElementById(elem);
                    popup.classList.add("active");
                }
        </script>
    </section>
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_closed">
            <h2 class="conf-step__title">{{ __('Конфигурация залов') }}</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">{{ __('Выберите зал для конфигурации:') }}</p>
            <ul class="conf-step__selectors-box">
                @foreach($halls as $hall)
                    <li>
                        @if($hall->{'id'} === $selected_hall)
                            <input type="radio" id="{{ $hall->id }}" data-rows="{{ $hall->row }}" data-cols="{{ $hall->col }}" onclick="radioInput(id)" class="conf-step__radio" name="1{{ $hall->id }}" value="{{ $hall->name }}" checked>
                            <span class="conf-step__selector">{{ $hall->name }}</span>
                        @else
                            <input type="radio" id="{{ $hall->id }}" data-rows="{{ $hall->row }}" data-cols="{{ $hall->col }}" onclick="radioInput(id)" class="conf-step__radio" name="1{{ $hall->id }}" value="{{ $hall->name }}">
                            <span class="conf-step__selector">{{ $hall->name }}</span>
                        @endif

                    </li>
                @endforeach
            </ul>
            <p class="conf-step__paragraph">{{ __('Укажите количество рядов и максимальное количество кресел в ряду:') }}</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">{{ __('Рядов') }}, {{ __('шт') }}<input id="rowsHall" type="number" class="conf-step__input" min="4" max="10" value="{{ $halls->where('id', $selected_hall)->first()->row }}"></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">{{ __('Мест') }}, {{ __('шт') }}<input id="colsHall" type="number" class="conf-step__input" min="4" max="12" value="{{ $halls->where('id', $selected_hall)->first()->col }}"></label>
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
    </section>
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_closed">
            <h2 class="conf-step__title">Конфигурация цен</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
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
            <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input id="priceNormal" type="text" class="conf-step__input" placeholder="{{ $halls->where('id', $selected_hall)->first()->count_normal }}" value="{{ $halls->where('id', $selected_hall)->first()->count_normal }}"></label>
                за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
            </div>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input id="priceVip" type="text" class="conf-step__input" placeholder="{{ $halls->where('id', $selected_hall)->first()->count_vip }}" value="{{ $halls->where('id', $selected_hall)->first()->count_vip }}"></label>
                за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
            </div>

            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input onclick="editPrice(id)" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </div>
    </section>
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <button id="addFilm" onclick = "clickAddFilm(id)" class="conf-step__button conf-step__button-accent">Добавить фильм</button>
            </p>
            <div class="conf-step__movies">
                @foreach($films as $film)
                    <x-admin.form action="{{ route('admin.destroyFilm', ['id' => $film->id]) }}" method="delete" onsubmit="return confirm('Удалить этот фильм?')">
                        <div id="{{ $film->id }}" class="conf-step__movie">
                            <img class="conf-step__movie-poster" alt="poster" src="{{ $film->image_path }}">
                            <h3 class="conf-step__movie-title">{{ $film->title }}</h3>
                            <p class="conf-step__movie-duration">{{ $film->duration }} минут</p>
                            <button href="#" class="task__remove visible conf-step__button conf-step__button-trash"></button>
                        </div>
                    </x-admin.form>

                @endforeach

            </div>

            <div class="conf-step__seances">
                @foreach($halls as $hall)
                    @php
                        $time = 0;
                        $seancesHall = $seances->where('hall_id', $hall->id)->unique('seance_start')->sortBy('seance_start')->values()->all();
                        $sortArraySeances = collect(\App\Models\Seance::where('hall_id', $hall->id)->get())->unique(
                            function ($item)
                            {
                                return substr($item['seance_start'], -8, 5);
                            })->sortBy('seance_start')->values()->all();
//                        dd($sortArraySeances);
                     @endphp
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">{{ $hall->name }}</h3>
                        <div class="conf-step__seances-timeline">
                            @foreach($sortArraySeances as $seance)
                                <div class="conf-step__seances-movie" style="width: calc({{ $films->where('id', $seance->{'film_id'})->first()->duration }}px*0.5); background-color: rgb(133, 255, 137); left: {{$time}}px;">
                                    <p class="conf-step__seances-movie-title">{{ $films->where('id', $seance->{'film_id'})->first()->title }}</p>
                                    <p class="conf-step__seances-movie-start">{{ substr($seance->{'seance_start'}, -8, 5) }}</p>
                                    @include('admin.delete_seance', ['seance'=> $seance, 'film'=> $films->where('id', $seance->{'film_id'})->first(), 'hall'=>$hall])
                                </div>
                                @php
                                    $time += ( $films->where('id', $seance->{'film_id'})->first()->duration )/2;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </div>
        @include('admin.add_film')
    </section>
    <script>
        function radioInput(id){
            let url = "{{ route('admin.index',['selected_hall' => 'id']) }}";
            id = String(id);
            url = url.replace('id', id);
            window.location.href= url
        }
        let btnList = document.querySelector('.conf-step__hall-wrapper');
        let rowsCount = document.getElementById('rowsHall');
        let colsCount = document.getElementById('colsHall');
        rowsCount.addEventListener('change', (e) => {
            let count = rowsCount.value
            let arrayRows = btnList.querySelectorAll('.conf-step__row');
            let countOld = arrayRows.length;
            let difference;
            console.log(count)
            console.log(countOld)
            if(count !== countOld){
                if (count < countOld) {
                    console.log('DElete row');
                    difference = Number(countOld) - Number(count);
                    for (let i = 0; i < arrayRows.length; i++) {
                        let index = countOld - 1;
                        let rowDelete = arrayRows[index]
                        rowDelete.remove();
                    }
                    console.log('difference = ' + difference)
                }
                if (count > countOld) {
                    console.log('edit row');
                    difference = Number(count) - Number(countOld);
                    for (let i = 1; i <= difference; i++) {

                        const row = document.createElement('div');
                        row.id = count;
                        row.classList.add('conf-step__row');
                        btnList.appendChild(row);
                        console.log('colsCount.value = ' + colsCount.value)
                        for (let j = 1; j <= colsCount.value; j++) {
                            const col = document.createElement('button');
                            col.setAttribute('data-type', "NORM");
                            col.classList.add('place');
                            col.classList.add('conf-step__chair');
                            col.classList.add('conf-step__chair_standart');
                            col.id = row.id +',' + j;
                            // col.onclick = select(rows[i].id +',' + j);
                            row.appendChild(col);
                        }
                    }
                }
            }
            // let difference =
        });
        let places = btnList.querySelectorAll('.place');
        for (let i = 0; i < places.length; i++) {
            let place = places[i];
            place.addEventListener('click', () => {
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
                        if(document.getElementById(place.id).dataset.type === 'VIP') {
                            place.classList.add('conf-step__chair_vip')
                            place.classList.remove('conf-step__chair_disabled')
                            place.classList.remove('conf-step__chair_standart')
                        } else if (document.getElementById(place.id).dataset.type === 'NORM') {
                            place.classList.remove('conf-step__chair_vip')
                            place.classList.remove('conf-step__chair_disabled')
                            place.classList.add('conf-step__chair_standart')
                        } else if (document.getElementById(place.id).dataset.type === 'FAIL') {
                            place.classList.remove('conf-step__chair_vip')
                            place.classList.add('conf-step__chair_disabled')
                            place.classList.remove('conf-step__chair_standart')
                        }
                    }
                }
            })
        }
        colsCount.addEventListener('change', (e) => {
            let count = colsCount.value
            console.log(count)
            let rows = btnList.querySelectorAll('.conf-step__row');
            for (let i = 0; i < rows.length; i++) {
                let row = rows[i];
                while (row.firstChild) {
                    row.removeChild(row.firstChild);
                }
                for (let j = 1; j <= colsCount.value; j++) {
                    const col = document.createElement('button');
                    col.setAttribute('data-type', "NORM");
                    col.classList.add('place');
                    col.classList.add('conf-step__chair');
                    col.classList.add('conf-step__chair_standart');
                    col.id = rows[i].id +',' + j;
                    col.onclick = select(rows[i].id +',' + j);
                    rows[i].appendChild(col);
                    console.log(rows[i].querySelectorAll('.place').length)
                    console.log(colsCount.value)
                    if(rows[i].querySelectorAll('.place').length === colsCount.value){
                        rows[i + 1].appendChild(col);
                    }
                }
            }
        })
        colsCount.addEventListener('mouseout', () => {
            console.log('123')
            let places = btnList.querySelectorAll('.place');
            for (let i = 0; i < places.length; i++) {
                let place = places[i];
                place.addEventListener('click', () => {
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
                            if(document.getElementById(place.id).dataset.type === 'VIP') {
                                place.classList.add('conf-step__chair_vip')
                                place.classList.remove('conf-step__chair_disabled')
                                place.classList.remove('conf-step__chair_standart')
                            } else if (document.getElementById(place.id).dataset.type === 'NORM') {
                                place.classList.remove('conf-step__chair_vip')
                                place.classList.remove('conf-step__chair_disabled')
                                place.classList.add('conf-step__chair_standart')
                            } else if (document.getElementById(place.id).dataset.type === 'FAIL') {
                                place.classList.remove('conf-step__chair_vip')
                                place.classList.add('conf-step__chair_disabled')
                                place.classList.remove('conf-step__chair_standart')
                            }
                        }
                    }
                })
            }
        })
        rowsCount.addEventListener('mouseout', () => {
            console.log('123')
            let places = btnList.querySelectorAll('.place');
            for (let i = 0; i < places.length; i++) {
                let place = places[i];
                place.addEventListener('click', () => {
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
                            if(document.getElementById(place.id).dataset.type === 'VIP') {
                                place.classList.add('conf-step__chair_vip')
                                place.classList.remove('conf-step__chair_disabled')
                                place.classList.remove('conf-step__chair_standart')
                            } else if (document.getElementById(place.id).dataset.type === 'NORM') {
                                place.classList.remove('conf-step__chair_vip')
                                place.classList.remove('conf-step__chair_disabled')
                                place.classList.add('conf-step__chair_standart')
                            } else if (document.getElementById(place.id).dataset.type === 'FAIL') {
                                place.classList.remove('conf-step__chair_vip')
                                place.classList.add('conf-step__chair_disabled')
                                place.classList.remove('conf-step__chair_standart')
                            }
                        }
                    }
                })
            }
        })
        let placesBtns = document.querySelectorAll('.place')
        for (let i = 0; i < placesBtns.length; i++) {
            let place = placesBtns[i];
            place.addEventListener('click', () => {

            })
        }
        function select(id){

        }

        function editSeat(id) {
            let newTypesHall = {};
            let countCol = document.getElementById('colsHall').value;
            let countRow = document.getElementById('rowsHall').value;
            let count_row_col = [countCol,countRow];
            let json_row_col = JSON.stringify(count_row_col);
            let btnsPlace = btnList.querySelectorAll('.conf-step__chair');
            for (let i = 0; i < btnsPlace.length; i++) {
                let button = btnsPlace[i];
                let id = button.id;
                newTypesHall[id] = button.dataset.type;
            }
            let json_string = JSON.stringify(newTypesHall);
            let url = "{{ route('admin.editHall', ['hall'=> $halls->where('id', $selected_hall)->first(), 'newTypeHall' => 'json_string', 'json_seat' => 'json_row_col']) }}"
            url = url.replace('json_string', json_string);
            url = url.replace('json_row_col', json_row_col);
            url = url.replaceAll('&amp;', '&');
            console.log(url)
            window.location.href = url;
        }

        function editPrice(id) {
            let priceNormal = document.getElementById('priceNormal').value;
            let priceVip = document.getElementById('priceVip').value;
            let prices_normal_vip = [priceNormal,priceVip];
            console.log(prices_normal_vip)
            let json_prices = JSON.stringify(prices_normal_vip);
            let url = "{{ route('admin.editPriceHall', ['hall'=> $halls->where('id', $selected_hall)->first(), 'json_price' => 'json_prices']) }}"
            url = url.replace('json_prices', json_prices);
            url = url.replaceAll('&amp;', '&');
            console.log(url)
            window.location.href = url;
        }

        function clickAddFilm(id){
            console.log(id)
            document.getElementById('popupAddFilm').classList.add('active');
        }
    </script>
@endsection

