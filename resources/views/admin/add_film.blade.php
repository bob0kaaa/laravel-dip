{{-- Меню popup добавления фильма--}}
<div class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление фильма
                    <a id="dismiss2" class="popup__dismiss" href="#" onclick = "cl3(id)"><img src="img/close.png" alt="Закрыть"></a>
                </h2>

            </div>
            <div class="popup__wrapper">
                <form action="{{route('admin.createFilm')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    {{--}}<form action="add_movie" method="post" accept-charset="utf-8">--}}
                    <label class="conf-step__label conf-step__label-fullsize" for="title">
                        Название фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Фильм&raquo;" name="title" required @if ($open === '1') disabled @endif>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="description">
                        Описание фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;О Фильме&raquo;" name="description" required @if ($open === '1') disabled @endif >
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="duration">
                        Длительность фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;130&raquo;" name="duration" required @if ($open === '1') disabled @endif >
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="origin">
                        Страна фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Россия&raquo;" name="origin" required @if ($open === '1') disabled @endif >
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="imagaPath">
                        Изображение фильма
                        <input type="file" class="form-control-file" name="imagePath" accept="image/png, image/jpeg" @if ($open === '1') disabled @endif >
                    </label>

                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >
                        <button id="cancel" onclick = "cl2(id)" class="conf-step__button conf-step__button-regular" @if ($open === '1') disabled @endif >Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> {{--popup--}}
