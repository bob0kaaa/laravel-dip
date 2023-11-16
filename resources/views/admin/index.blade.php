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
                <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 1"><span class="conf-step__selector">Зал 1</span></li>
                <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 2" checked><span class="conf-step__selector">Зал 2</span></li>
            </ul>

            <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" ></label>
                за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
            </div>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" value="350"></label>
                за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
            </div>

            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </div>
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
            console.log(count_row_col);
            let btnsPlace = btnList.querySelectorAll('.conf-step__chair');
            for (let i = 0; i < btnsPlace.length; i++) {
                let button = btnsPlace[i];
                let id = button.id
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
    </script>
@endsection

