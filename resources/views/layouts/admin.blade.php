<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page.title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>

<body>
@include('includes.header')

<main class="conf-steps">
    @yield('content')
</main>
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
        let url = "{{route('admin.createSeance', ['film_id'=> 'filmId', 'hall_id'=> 'hallId', 'start_seance' => 'startSeance'])}}";
        url = url.replace('startSeance', form.elements[2].value);
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
        let url = "{{ route('admin.home',['confstep'=> ['conf-step__header_closed',  'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed'], 'selected_hall' => 'id', 'open'=> $open, 'text'=> $text]) }}";
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
        let url = "{{ route('admin.home',['confstep'=> ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed'], 'selected_hall' => 'id', 'open'=> $open, 'text'=> $text]) }}";
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
</body>
</html>
