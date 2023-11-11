@extends('layouts.base')

@section('content')
    <span class="page-header__subtitle">Администраторррская</span>
    @if(session('status'))
        <div class="conf-step__paragraph c">
            {{session('status')}}
        </div>
    @endif
    <section id="1" class="conf-step">
        <header class="conf-step__header {{$confStep[0]}}">
            <h2 class="conf-step__title">Управление залами</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Доступные залы:</p>

            <ul class="conf-step__list">
                @foreach ($halls as $hall)
                    {{-- Форма создания зала--}}
                    <li>{{$hall->name}}
                        {{-- Форма создания зала popup--}}
                        @include('admin.delete', ['hall'=> $hall])
                        <button id="{{$hall->id}}" onclick = "popupToggle(id)"  class="conf-step__button conf-step__button-trash" @if ($open === '1') disabled @endif >
                        </button>
                    </li>
                @endforeach
            </ul>
            <button id= "create" onclick = "clickAddHall(id)"  class="conf-step__button conf-step__button-accent" @if ($open=== '1') disabled @endif>Создать зал</button>

        </div>
        @include('admin.add_hall') {{-- подключаем Меню popup добавления зала--}}

    </section>
    <section id="2" class="conf-step">
        <header class="conf-step__header {{$confStep[1]}}">
            <h2 class="conf-step__title">Конфигурация залов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">
                @foreach ($halls as $hall)
                    <li>
                        @php
                            $hall_seances= $seances->where('hall_id', $hall->id);

                            if(count($hall_seances)>0) {
                             $edit_hall = '0';
                            } else {
                             $edit_hall = '1';
                            }
                        @endphp
                        {{--можно поставить проверку если  $edit_hall = '1', то рисовать залы if кода ниже
                        (при этом убрать  в input  условие с $edit_hall)--}}
                        @if($hall->{'id'} == $selected_hall)

                            <input id="{{$hall->{'id'} }}" onclick = "clickRadio(id)" type="radio" class="conf-step__radio"  name="chairs-hall" value="{{$hall->name}}" checked @if ($open === '1') disabled @endif @if ($edit_hall === '0') disabled @endif  ><span class="conf-step__selector tooltip" data-tooltip="Зал не доступен для редактирования при наличии в нем сеансов">{{$hall->name}}</span></li>
                    @else
                        <input id="{{$hall->{'id'} }}" onclick = "clickRadio(id)" type="radio" class="conf-step__radio" name="chairs-hall" value="{{$hall->name}}" @if ($open === '1') disabled @endif @if ($edit_hall === '0') disabled @endif ><span class="conf-step__selector tooltip" data-tooltip="Зал не доступен для редактирования при наличии в нем сеансов">{{$hall->name}}</span></li>
                        @endif
                        </li>
                        @endforeach
            </ul>

            <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Рядов, шт<input id="countRow" type="text" class="conf-step__input seats" placeholder=" {{$halls->where('id',$selected_hall)->first()->row }} " value=" {{$halls->where('id',$selected_hall)->first()->row }} " @if ($open === '1' || $edit_hall === '0') disabled @endif></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">Мест, шт<input id="countCol" type="text" class="conf-step__input seats" placeholder=" {{$halls->where('id',$selected_hall)->first()->col }} " value=" {{$halls->where('id',$selected_hall)->first()->col }} " @if ($open === '1' || $edit_hall === '0') disabled @endif ></label>
            </div>
            <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>
            {{-- Схема зала--}}
            @php
                $isTrue = false;
            @endphp

            <x-admin.buttons :open="$open" :disabled="$isTrue" :seats="$seats" :seance="$seances" :film="$films" :hall="$halls->where('id',$selected_hall)->first()" :selected_hall="$selected_hall">
            </x-admin.buttons>

        </div>
    </section>
    <section id="3" class="conf-step">
        <header class="conf-step__header {{$confStep[2]}}">
            <h2 class="conf-step__title">Конфигурация цен</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">
                @foreach ($halls as $hall)
                    <li>
                        @php
                            $hall_seances= $seances->where('hall_id', $hall->id);
                            if(count($hall_seances)>0) {
                             $edit_hall = '0';
                            } else {
                             $edit_hall = '1';
                            }
                        @endphp

                        @if($hall->{'id'} == $selected_hall)
                            <input id="{{$hall->id}}" onclick = "clickRadio2(id)" type="radio" class="conf-step__radio" name="prices-hall" value="{{$hall->name}}" checked @if ($open === '1') disabled @endif @if ($edit_hall === '0') disabled @endif ><span class="conf-step__selector tooltip" data-tooltip="Зал не доступен для редактирования при наличии в нем сеансов">{{$hall->name}}</span> </li>
                    @else
                        <input id="{{$hall->id}}" onclick = "clickRadio2(id)" type="radio" class="conf-step__radio" name="prices-hall" value="{{$hall->name}}" @if ($open === '1') disabled @endif  @if ($edit_hall === '0') disabled @endif ><span class="conf-step__selector tooltip" data-tooltip="Зал не доступен для редактирования при наличии в нем сеансов">{{$hall->name}}</span> </li>
                        @endif
                        </li>
                        @endforeach
            </ul>

            <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input id="count_normal" type="text" class="conf-step__input count" placeholder="0" value="{{ $halls->where('id',$selected_hall)->first()->count_normal ?: $halls->all()->first()->count_normal }}" @if ($open === '1' || $edit_hall === '0') disabled @endif ></label>
                за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
            </div>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input id="count_vip" type="text" class="conf-step__input count" placeholder="0" value="{{ $halls->where('id',$selected_hall)->first()->count_vip ?: $halls->all()->first()->count_normal }}" @if ($open === '1' || $edit_hall === '0') disabled @endif ></label>
                за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
            </div>

            <fieldset class="conf-step__buttons text-center">
                <button onclick = " window.location.href='{{ route('admin.index', ['confStep'=> ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed'], 'open'=> $open,'selected_hall' => $selected_hall]) }}' " href="#" class="conf-step__button conf-step__button-regular" @if ($open === '1') disabled @endif>Отмена</button>
                <input id="{{$hall->id}}" onclick = "clickEditPrice(id)" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >

                {{--<input id="update" onclick = "clickUpdate()" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >--}}
            </fieldset>
        </div>
    </section>
    <section id="4" class="conf-step">
        <header class="conf-step__header {{$confStep[3]}}">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <button id="addFilm" onclick = "clickAddFilm(id)" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >Добавить фильм</button>
            </p>
            {{--Блок оглавления фильмов --}}

            <div class="conf-step__movies">
                @foreach ($films as $film)

                    <div class="conf-step__movie" draggable="true" style="cursor: grabbing;">
                        {{-- Форма добавления фильма--}}

                        <form  action="{{ route('admin.destroyFilm', ['id' => $film->id]) }}" method="post" onsubmit="return confirm('Удалить этот фильм?')">
                            @csrf
                            @method('DELETE')
                            @php
                                $path= 'storage/folder/'.$film->image_path;
                            @endphp
                            {{--Возможность удаления фильма  --}}
                            <button type="image" @if ($open === '1') disabled @endif ><img class="conf-step__movie-poster" alt="{{$film->image_text}}" src="{{ asset($film->image_path)}}" ></button>
                            <h3 class="conf-step__movie-title">{{$film->title}}</h3>
                            <p class="conf-step__movie-duration">{{$film->duration}} минут</p>
                            <button href="#" class="task__remove visible conf-step__button conf-step__button-trash" @if ($open === '1') disabled @endif></button>
                        </form>

                        @include('admin.add_seance', ['film'=> $film, 'halls'=> $halls])

                    </div>
                @endforeach
            </div>
            {{--конец блок оглавления фильмов --}}

            {{--Блок сетки фильмов --}}
            <div class="conf-step__seances">
                {{-- сетка фильмов для зала  --}}
                @foreach ($halls as $hall)
                    <div id="{{$hall->id}}" class="conf-step__seances-hall drop-area-into">
                        <h3 class="conf-step__seances-title">{{$hall->name}}</h3>
                        <div class="conf-step__seances-timeline drop-area">
                            @php
                                $coord = 0;
                            @endphp
                            @php
                                $all_seances = $seances->where('hall_id', $hall->id)->unique('startSeance')->sortBy('startSeance')->values()->all();
                                $unique = collect(App\Models\Seance::where('hall_id', $hall->id)->get())->unique(function ($item) {
                                return substr($item['startSeance'], -8, 5);
                                })->sortBy('startSeance')->values()->all();
                            @endphp
                            @foreach ($unique as $seance)
                                <div class="conf-step__seances-movie" draggable="true" style="width: calc({{ $films->where('id', $seance->{'film_id'})->first()->duration }}px*0.5); background-color: rgb(133, 255, 137); left: {{$coord}}px;">
                                    <p class="conf-step__seances-movie-title">{{ $films->where('id', $seance->{'film_id'})->first()->title }}</p>
                                    <p class="conf-step__seances-movie-start">{{ substr($seance->{'startSeance'}, -8,5) }}</p>
                                    @include('admin.delete_seance', ['seance'=> $seance, 'film'=> $films->where('id', $seance->{'film_id'})->first(), 'hall'=>$hall])
                                </div>
                                @php
                                    $coord += ( $films->where('id', $seance->{'film_id'})->first()->duration )/2;
                                @endphp

                            @endforeach

                        </div>
                    </div>
                @endforeach
                <fieldset class="conf-step__buttons text-center">
                    {{--}}<button class="conf-step__button conf-step__button-regular" href="#" @if ($open === '1') disabled @endif >Отмена</button>--}}
                    <button  id="cancel"  onclick = " window.location.href='{{ route('admin.index', ['confStep' => ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed'],'open'=> $open,'selected_hall' => $hall->{'id'}]) }}' " href="#" class="conf-step__button conf-step__button-regular" @if ($open === '1') disabled @endif >Отмена</button>
                    <input  type="submit" value="Сохранить"  id="save"  onclick = " window.location.href='{{ route('admin.index', ['confStep' => ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed'],'open'=> $open,'selected_hall' => $hall->{'id'}]) }}' " href="#" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >
                </fieldset>
            </div>
            {{--Конец блока сетки фильмов <div class="conf-step__seances">--}}
            @include('admin.add_film') {{-- подключаем Меню popup добавления фильма--}}
        </div> {{-- wrapper?--}}
    </section>
    <section id="5" class="conf-step">
        <header class="conf-step__header {{$confStep[4]}}">
            <h2 class="conf-step__title">Открыть продажи</h2>
        </header>
        <div class="conf-step__wrapper text-center">
            <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
            <button id="open" onclick = "clickOpen(id)" class="conf-step__button conf-step__button-accent active" value="{{$open}}">{{$text}}</button>
        </div>
    </section>
@endsection
<script>
    let idLast = 1;
    const input = document.querySelectorAll('.count');//кнопки input цен
    const input_row_col = document.querySelectorAll('.seats');//кнопки input место/ряд

    const input_button = [...Array.of(document.querySelectorAll('button')), ...Array.of(document.querySelectorAll('input'))];
    console.log('все кнопки и инп',input_button);

    let count = [0,0];
    let count_row_col = [0,0];
    let json_row_col = JSON.stringify(count_row_col);// типы мест
    let json_count = JSON.stringify(count);// стоимость мест

    //Обработчик ввода стоимости места в зале
    Array.from(input).forEach((button, index, arr) => {
        button.oninput = function () {
            //count[index] = button.value;
            console.log(button.value, arr[index].value, count);
        }
        button.onchange = function () {
            count[index] = button.value;
            console.log('конец');
            console.log(button.value, count, count.length);
            json_count=JSON.stringify(count);
            console.log('count json_count:', json_count);

        }
    });
    document.getElementById('update');


    //Обработчик ввода ряда, места в зале////повтор
    Array.from(input_row_col).forEach((button, index, arr) => {
        button.oninput = function () {
            //count[index] = button.value;
            console.log(button.value, arr[index].value, count_row_col);
        }
        button.onchange = function () {
            count_row_col[index] = button.value;
            json_row_col=JSON.stringify(count_row_col);
            console.log('конец');
            console.log(button.value, count_row_col, count_row_col.length);
            console.log('count json_row_col:', json_row_col);
            editSeats(idLast);
        }
    });
    // обработка установки цветности карточек сеансов
    const backcolor = ['#caff85', '#85ff89', '#85ffd3','#85e2ff', '#8599ff', '#ba85ff', 'ff85fb','#ff85b1', '#ffa285'];
    const movieparent = Array.from(document.querySelectorAll('.conf-step__movie'));//кнопки h3
    const movie = Array.from(document.querySelectorAll('.conf-step__movie-title'));//кнопки h3
    const seance = Array.from(document.querySelectorAll('.conf-step__seances-movie-title'));//h3
    movieparent.forEach((pp, index,arr) => {
        console.log('ht,tyjr',pp);
    });

    seance.forEach((p, index, arr) => {
        console.log(p, p.textContent);
        const element = movie.find((el)=> el.textContent == p.textContent);
        const idxelementparent = movieparent.findIndex((el)=> el == element.closest('.conf-step__movie'));
        (idxelementparent != -1 && idxelementparent<9) ? p.closest('.conf-step__seances-movie').style.backgroundColor= backcolor[idxelementparent] : backcolor[0];

    });

    //для диплома drag-drop film
    let idHallForSelect= 0;

    const shows1 = (id) => {
        //поставить нужный зал в select
        let selected = Array.from(document.forms[`seance${id}`].select_hall.options);
        selected.forEach((p, index, arr) => {
            console.log('element:\n',p.value);
            if(p.value === idHallForSelect) {
                document.forms[`seance${id}`].select_hall.selectedIndex= index;
            }
        });

        // показать меню добавления сеанса
        const popupe = `.conf-step__movie #popup${id}.popup`;
        console.log('popup',popupe);
        console.log('id',id);
        const headers = document.querySelector(popupe);
        console.log('popup element', headers);
        headers.classList.toggle('active');
    }

    const shows2 = (id) => {

        // показать меню удаления сеанса
        const popupe = `.conf-step__seances-movie #id?.popup`;
        console.log(popupe);
        const headers = document.getElementById(`${id}`);
        console.log('popup element', headers);
        headers.classList.toggle('active');
    }


    // все карточки фильма, навешиваем обработчики
    const cards2 = [...Array.from(document.querySelectorAll('.conf-step__movie'))];
    console.log('cards2 i this', this, cards2);
    let isDragging = false;
    for (const card of cards2) {
        card.onmouseenter = function Enter(e) {
            e.preventDefault();// если без span  то везде children 0!!!
            isDragging = true;
            if (e.target.classList.contains('.conf-step__movie') && e.target.children[2].classList.contains('.visible')) {
                e.target.children[2].classList.remove('visible');

            }

            card.addEventListener('mousedown', (event) => {
                if (event.target.classList.contains('task__remove')) {
                    return;
                }
                if(!isDragging){
                    return;
                }

                event.preventDefault();
                let draggedEl = null;
                let ghostEl = null;

                let element3 = event.target.closest('.conf-step__movie');
                console.log('===========e.target =======element3!!!!', event.target, element3);              ///

                if (!e.target.classList.contains('conf-step__movie')) {
                    return;
                }                                                             ///

                if (event.target.closest('.conf-step__movie').classList.contains('conf-step__movie')) {

                    element3.style.cursor = 'grabbing';
                    draggedEl = element3;
                    console.log('тянем это div', draggedEl);

                    ghostEl = element3.cloneNode(true);
                    ghostEl.classList.add('dragged');
                    document.body.appendChild(ghostEl);
                    ghostEl.style.position = 'absolute';
                    ghostEl.style.zIndex = 1000;
                    ghostEl.style.width = `${element3.offsetWidth}px`;
                    ghostEl.style.left = `${event.pageX - ghostEl.offsetWidth / 2}px`;
                    ghostEl.style.top = `${event.pageY - ghostEl.offsetHeight / 2}px`;
                    ghostEl.style.backgroundColor = 'green';
                    ghostEl.style.opacity = 0.6;
                    console.log('скопировали это dip', ghostEl);
                }

                console.log('слушаем это dip', card.closest('.conf-step__movies').nextElementSibling);
                card.closest('.conf-step__movies').nextElementSibling.addEventListener('mousemove', (e) => {
                    e.preventDefault(); // не даём выделять элементы
                    if(!isDragging){
                        return;
                    }

                    if (!draggedEl) {
                        return;
                    }


                    ghostEl.style.left = `${e.pageX - ghostEl.offsetWidth / 2}px`;
                    ghostEl.style.top = `${e.pageY - ghostEl.offsetHeight / 2}px`;
                    console.log('позиция', ghostEl.style.left, ghostEl.style.top);
                    console.log('event mousemove\n', e.target, e.currentTarget);
                });
                //отпустили блок
                document.addEventListener('mouseup', (e) => {
                    //e.stopPropagation();
                    e.preventDefault(); // не даём выделять элементы

                    //сразу сбросить обработчик движения
                    for (const card of cards2) {
                        card.closest('.conf-step__movies').nextElementSibling.removeEventListener('mousemove', (e) => {
                            e.preventDefault();
                            //e.stopPropagation();
                        });
                    }

                    if(!isDragging){
                        return;
                    }
                    // e.stopPropagation();
                    console.log('event mouseup!!!!!!', e.target, e.currentTarget, e.relatedTarget);
                    console.log('draddedEl', draggedEl);
                    console.log('ghost', ghostEl);

                    if (!draggedEl) {
                        return;
                    }

                    let closest = document.elementFromPoint(e.clientX, e.clientY);// p- элемент
                    console.log('closest 1 и 2\n', closest, document.elementsFromPoint(e.clientX, e.clientY));
                    console.log('dragged parent\n', draggedEl.parentElement, draggedEl.parentElement.parentNode);
                    console.log('ghostd parent\n', ghostEl.parentElement, ghostEl.parentElement.parentNode);

                    let closestParent = closest.closest('.conf-step__movie');//div
                    console.log('closestparent   2el\n', closestParent);

                    console.log('element3\n', element3);
                    let parent, col;
                    for (const el of [...Array.from(document.elementsFromPoint(e.clientX, e.clientY))]) {
                        if (el.classList.contains('conf-step__seances-timeline')) {
                            console.log("ребенок ok555555", el);
                            parent = el;
                            idHallForSelect= parent.parentElement.id;

                        }
                        console.log("ребенок", el);
                        console.log("idHallForSelect", idHallForSelect);
                    }

                    console.log('parent conf-step__seances-hall\n', parent);
                    //let parent = closest.closest('.conf-step__seances-timeline.drop-area');

                    console.log('кидаем это на e.currentTarget', '\n ghostEl', ghostEl, '\n dragged', draggedEl, '\n etarget', e.target, '\n closest', closest, '\n carrenttag', e.currentTarget);
                    console.log('childrene.currentTarget', e.currentTarget.children);
                    console.log('childrene.Target', e.target.children);

                    const {top} = closest.getBoundingClientRect();
                    console.log('вставляем сюда', parent);

                    document.body.removeChild(ghostEl);
                    console.log('\n ghostEl', ghostEl.children[1].id[5]);
                    const idd = ghostEl.children[1].id[5];

                    ghostEl = null;
                    draggedEl = null;
                    //card.onmouseenter = null;


                    // сбрасываем все остальные обработчики (mousemove раньше всех)
                    document.removeEventListener('mouseup', (e) => {
                        e.preventDefault();
                        //e.stopPropagation();
                    });
                    for (const card of cards2) {

                        /*card.closest('.conf-step__movies').nextElementSibling.removeEventListener('mousemove', (e) => {
                            e.preventDefault();
                            //e.stopPropagation();
                        });*/

                        card.removeEventListener('mousedown', (e) => {
                            e.preventDefault();
                            //e.stopPropagation();
                        });

                        card.onmouseenter = null;
                        card.onmouseleave = null;

                    }

                    //показать попап
                    shows1(idd);
                    isDragging = false;
                });
            });//  mousedown
            //}; //if
        };

        card.onmouseleave = function Leave(ev) {
            ev.preventDefault();
        };

    }//for


    // удаление сеанса --------------------------------------------------------------
    //// все сеансы с фильмами, навешиваем обработчики
    const cardsIseances = [...Array.from(document.querySelectorAll('.conf-step__seances-movie'))];
    console.log('cards_seances i this', this, cardsIseances);
    for (const card of cardsIseances) {
        let isDrag = false;
        card.onmouseenter = function Enter(e) {
            e.preventDefault();// если без span  то везде children 0!!!
            isDrag = true;
            if (e.target.classList.contains('.conf-step__seances-movie') && e.target.children[2].classList.contains('.visible')) {
                e.target.children[2].classList.remove('visible');
            }

            card.addEventListener('mousedown', (event) => {
                if (event.target.classList.contains('task__remove')) {
                    return;
                }
                if (!isDrag) {
                    return;
                }

                event.preventDefault();
                let draggedEl = null;
                let ghostEl = null;

                let element3 = event.target.closest('.conf-step__seances-movie');
                console.log('===========e.target =======element3!!!!', event.target, element3);              ///

                if (!e.target.classList.contains('conf-step__seances-movie')) {
                    return;
                }                                                             ///

                if (event.target.closest('.conf-step__seances-movie').classList.contains('conf-step__seances-movie')) {

                    element3.style.cursor = 'grabbing';
                    draggedEl = element3;
                    console.log('тянем это div', draggedEl);

                    ghostEl = element3.cloneNode(true);
                    ghostEl.classList.add('dragged');
                    document.body.appendChild(ghostEl);
                    ghostEl.style.position = 'absolute';
                    ghostEl.style.zIndex = 1000;
                    ghostEl.style.width = `${element3.offsetWidth}px`;
                    ghostEl.style.left = `${event.pageX - ghostEl.offsetWidth / 2}px`;
                    ghostEl.style.top = `${event.pageY - ghostEl.offsetHeight / 2}px`;
                    ghostEl.style.backgroundColor = 'green';
                    ghostEl.style.opacity = 0.6;
                    console.log('скопировали это dip', ghostEl);
                }

                card.closest('.conf-step__seances-movie').addEventListener('mousemove', (e) => {
                    e.preventDefault(); // не даём выделять элементы
                    e.stopPropagation();
                    if (!isDrag) {
                        return;
                    }

                    if (!draggedEl) {
                        return;
                    }

                    ghostEl.style.left = `${e.pageX - ghostEl.offsetWidth / 2}px`;
                    ghostEl.style.top = `${e.pageY - ghostEl.offsetHeight / 2}px`;
                    console.log('позиция', ghostEl.style.left, ghostEl.style.top);
                    console.log('event mousemove\n', e.target, e.currentTarget);

                });

                //up
                document.addEventListener('mouseup', (e) => {

                    e.preventDefault(); // не даём выделять элементы

                    //сразу сбросить обработчик движения
                    for (const card of cardsIseances) {
                        card.closest('.conf-step__seances-movie').removeEventListener('mousemove', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                        });
                    }

                    // сбрасываем все остальные обработчики (mousemove раньше всех)
                    document.removeEventListener('mouseup', (e) => {
                        e.preventDefault();

                    });

                    for (const card of cardsIseances) {

                        card.removeEventListener('mousedown', (e) => {
                            e.preventDefault();

                        });

                        card.onmouseenter = null;
                        card.onmouseleave = null;
                    }


                    if (!isDrag) {
                        return;
                    }

                    console.log('event mouseup!!!!!!', e.target, e.currentTarget, e.relatedTarget);
                    console.log('draddedEl', draggedEl);
                    console.log('ghost', ghostEl);

                    if (!draggedEl) {
                        return;
                    }

                    let closest = document.elementFromPoint(e.clientX, e.clientY);// p- элемент
                    console.log('closest 1 и 2\n', closest, document.elementsFromPoint(e.clientX, e.clientY));
                    console.log('dragged parent\n', draggedEl.parentElement, draggedEl.parentElement.parentNode);
                    console.log('ghostd parent\n', ghostEl.parentElement, ghostEl.parentElement.parentNode);

                    let closestParent = closest.closest('.conf-step__seances-movie');//div
                    console.log('closestparent   2el\n', closestParent);

                    console.log('element3\n', element3);

                    let parent, col;
                    for (const el of [...Array.from(document.elementsFromPoint(e.clientX, e.clientY))]) {
                        if (el.classList.contains('conf-step__seances-timeline')) {
                            console.log("ребенок ok555555", el);
                            parent = el;
                            idHallForSelect = parent.parentElement.id;

                        }
                        console.log("ребенок", el);
                        console.log("idHallForSelect", idHallForSelect);
                    }

                    console.log('parent conf-step__seances-hall\n', parent);

                    console.log('кидаем это на e.currentTarget', '\n ghostEl', ghostEl, '\n dragged', draggedEl, '\n etarget', e.target, '\n closest', closest, '\n carrenttag', e.currentTarget);
                    console.log('childrene.currentTarget', e.currentTarget.children);
                    console.log('childrene.Target', e.target.children);

                    const {top} = closest.getBoundingClientRect();
                    console.log('вставляем сюда', parent);

                    document.body.removeChild(ghostEl);
                    console.log('\n ghostEl', ghostEl.children[2].id);
                    const idd = ghostEl.children[2].id;//id=seance_id_film_id

                    ghostEl = null;
                    draggedEl = null;
                    //card.onmouseenter = null;
                    //показать попап
                    shows2(idd);
                    isDrag = false;
                });//  mouseup
            });//down
        };
        //enter
        card.onmouseleave = function Leave(ev) {
            ev.preventDefault();
        };

    }

    //==================================== function==========================
    // Обработка выбора типа места по клику
    function select(id, hall){
        let rand;
        console.log(id);
        let type= id.split(' ');//conf-step__chair conf-step__chair_
        let arr=['VIP','NORM','FAIL'];
        let arr2={'VIP':'vip', 'NORM':'standart','FAIL':'disabled'};
        rand = arr.indexOf(type[1]);
        console.log('rand',rand);

        console.log('после деления',type[1]);
        console.log('dele тип в массиве', arr);
        console.log(document.getElementById(id).closest('.conf-step'));

        if (rand === 0) {
            rand = 1;}
        else if (rand === 1) {
            rand= 2;}
        else if (rand === 2) {
            rand= 0;}
        console.log('rand',rand);
        console.log('arr2[type[1]]:', arr2[type[1]]);

        let classDelete = `conf-step__chair conf-step__chair_${arr2[type[1]]}`;
        let classSelect = `conf-step__chair conf-step__chair_${arr2[arr[rand]]}`;

        console.log(document.getElementById(id).classList);
        console.log(classSelect);
        document.getElementById(id).classList.value = classDelete;
        console.log('после удал',document.getElementById(id).classList);
        document.getElementById(id).classList.value = classSelect;
        console.log('после добавл',document.getElementById(id).classList);
        //console.log('заменяем id у',document.getElementById(id));
        document.getElementById(id).id = `${type[0]} ${arr[rand]}`;
        console.log('id после замены',document.getElementById(`${type[0]} ${arr[rand]}`));

    }

    function editSeats(id){
        // Меняем массив typeOfSeats - типы мест в зале(нажатие сохранить)
        console.log('editSeats');
        let newTypeOfSeats= [];
        Array.of(document.querySelectorAll('button.conf-step__chair')).forEach((element, index, array) => {
            console.log('кнопка',index, array[index]);
            for(let i=0; i<element.length; i++) {
                const elementSplite = element[i].id.split(' ');
                console.log('massiv splite',elementSplite, elementSplite[0], elementSplite[1]);
                //newTypeOfSeats.push(element[i].id);
                let key = elementSplite[0];
                let value = elementSplite[1];
                newTypeOfSeats.push({key: key, value: value});
                console.log('massiv',newTypeOfSeats[i]);
            }
        });

        let json_string=JSON.stringify(newTypeOfSeats);
        //let url = "{{--route('admin.editHall', ['hall'=> $hall, 'newTypeOfSeats' => 'json', 'user'=> $user, 'films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => $dateCurrent, 'dateChosen'=> $dateChosen, 'seats'=> $seats])--}}";

        // было работало let url = "{{--route('admin.editHall', ['hall'=> $halls->where('id', $selected_hall)[0], 'newTypeOfSeats' => 'json', 'json_seat' => 'json_row_col'])--}}";
        let url = "{{route('admin.editHall', ['hall'=> $halls->where('id', $selected_hall)->first(), 'newTypeOfSeats' => 'json_string', 'json_seat' => 'json_row_col'])}}";

        url = url.replace('json_string', json_string);//console.log('replace url  ', url);
        url = url.replace('json_row_col', json_row_col);
        console.log('replace url  ', url);
        console.log('count json_row:', json_row_col);
        url = url.replaceAll('&amp;', '&');
        console.log('получили url для обновления   ',url);
        window.location.href = url;
    }
    // редактирование цен
    function clickEditPrice(id){
        let url = "{{route('admin.editPriceHall', ['hall'=> $halls->where('id', $selected_hall)->first(), 'count' => 'json_count'])}}";
        url = url.replace('json_count', json_count);
        console.log('replace url  ', url);
        url = url.replaceAll('&amp;', '&');
        console.log('получили url для обновления   ',url);
        window.location.href = url;
    }
    // создание сеанса
    function clickCreateSeance(id) {
        const  formsSeance= document.forms;
        console.log('формs\n', formsSeance);
        Array.from(formsSeance).forEach((pp, index,arr) => {
            console.log('formmmmmm',pp);
        });


        const form= document.forms[`seance${id}`];
        console.log('form',form);
        console.log('form elements', form.elements);
        console.log('form elements gjokkk',form.elements[0].value, form.elements[1].value, form.elements[2].value);
        let selected = Array.from(document.forms[`seance${id}`].select_hall.options);
        console.log('select ', selected, document.forms[`seance${id}`].select_hall.innerText, document.forms[`seance${id}`].select_hall.selectedIndex);
        console.log('элемент', selected[document.forms[`seance${id}`].select_hall.selectedIndex].innerText, 'id',selected[document.forms[`seance${id}`].select_hall.selectedIndex].value, form.elements[2].value);
        let url = "{{route('admin.createseance', ['film_id'=> 'filmId', 'hall_id'=> 'hallId', 'start_seance' => 'seance_start'])}}";
        url = url.replace('seance_start', form.elements[2].value);
        url = url.replace('filmId', id);
        url = url.replace('hallId', selected[document.forms[`seance${id}`].select_hall.selectedIndex].value);
        console.log('replace url  ', url);
        url = url.replaceAll('&amp;', '&');
        console.log('получили url для обновления   ',url);
        window.location.href = url;
    }

    //Открыть форму добавления зала/фильма
    function clickAddFilm(id){
        console.log(id);
        console.log(document.getElementById(id));
        //console.log(document.getElementById(id).closest('.conf-step'));
        console.log(document.getElementById(id).closest('.conf-step__wrapper').children[3]);
        document.getElementById(id).closest('.conf-step__wrapper').children[3].classList.add("active");
    }
    //Открыть форму добавления зала/фильма
    function clickAddHall(id){
        console.log(id);
        console.log(document.getElementById(id));
        //console.log(document.getElementById(id).closest('.conf-step'));
        console.log(document.getElementById(id).closest('.conf-step').children[2]);
        document.getElementById(id).closest('.conf-step').children[2].classList.add("active");
    }

    //Закрыть форму добавления зала/фильма
    function cl2(id){
        document.getElementById(id).closest('.conf-step').children[2].classList.remove("active");
    }

    //Закрыть popup форму добавления зала/ фильма
    function cl3(id){
        console.log(id);
        console.log("родитель с active", document.getElementById(id).closest('.popup'));
        document.getElementById(id).closest('.popup').classList.remove("active");
        console.log("родитель ,tp active", document.getElementById(id).closest('.popup'));
    }

    //Выбор кресла id /в выбранном зале idLast
    function scheme(id){
        console.log(id);
        console.log(idLast);
    }

    //Переключатель зала 1
    function clickRadio(id){
        console.log('clickradio', id);
        idLast = id;
        let url = "{{ route('admin.index',['confStep'=> ['conf-step__header_closed',  'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed'], 'selected_hall' => 'id', 'open'=> $open, 'text'=> $text]) }}";
        let idi = String(id);
        console.log('idi', id);
        url = url.replace('id', +idi);    //url = url.replace('open_2', `${ {{--$open --}}}`);
        url = url.replaceAll('&amp;', '&');
        console.log('replaceed amp url  ', url);   // alert(url);
        window.location.href= url
    }

    //Переключатель зала 2
    function clickRadio2(id){
        console.log('clickradio', id);
        idLast = id;
        let url = "{{ route('admin.index',['confStep'=> ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed'], 'selected_hall' => 'id', 'open'=> $open, 'text'=> $text]) }}";
        let idi = String(id);
        console.log('idi', id);
        url = url.replace('id', +idi);
        url = url.replaceAll('&amp;', '&');
        window.location.href= url
    }

    // переключатель блокировка/разблокировка редактирования(добавление св-ва disabled)
    function disabled(parametr) {
        console.log(parametr);
        input_button.forEach((element, index, array) => {
            for(let i=0; i<element.length; i++) {
                element[i].disabled = parametr;
                console.log('massiv ',element[i], element[i].disabled);
            }
        });
    }

    // переключатель открытие/закрытие продаж
    function clickOpen(id)
    {
        elem = document.getElementById(`${id}`);
        console.log(elem, +elem.value, !Boolean(+elem.value));
        url = "{{ route('admin.open',['param' => 'id']) }}";
        url = url.replace('id', +!Boolean(+elem.value));
        url = url.replaceAll('&amp;', '&');
        console.log('replaceed amp url  ', url);
        console.log(url);
        elem.value = +!Boolean(+elem.value);
        console.log(elem.value, " new value ",elem);
        if(elem.value === "1") {
            disabled(true);
        } else {
            disabled(false);
        }
        elem.disabled = false;
        window.location.href= url
    }

    function popupToggle(id){
        let p= 'popup'+`${id}`;
        const  popup = document.getElementById(p);
        popup.classList.toggle('active')
    }
    function popupToggle2(id){
        const  popup = document.getElementById(id);
        const pop = popup.closest('.popup');
        pop.classList.toggle('active')
    }
    //dragdrop
</script>
