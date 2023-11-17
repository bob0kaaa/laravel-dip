{{-- Меню popup изменение фильма--}}
<div id="edit-film" class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление фильма
                    <a id="dismiss2" class="popup__dismiss" href="#" onclick = "closePopup(id)"><img src="img\close.png" alt="Закрыть"></a>
                </h2>

            </div>
            <div class="popup__wrapper">
                <form action="{{route('admin.update'), ['film' => $film]}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf

                    <label class="conf-step__label conf-step__label-fullsize" for="title">
                        Название фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Фильм&raquo;" name="title" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="description">
                        Описание фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;О Фильме&raquo;" name="description" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="duration">
                        Длительность фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;130&raquo;" name="duration" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="origin">
                        Страна фильма
                        <input class="conf-step__input" type="text" placeholder="Например, &laquo;Россия&raquo;" name="origin" required>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="imagaPath">
                        Изображение фильма
                        <input type="file" class="form-control-file" name="image_path" accept="image/png, image/jpeg">
                    </label>

                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent">
                        <button id="cancel" onclick = "closePopup(id)" class="conf-step__button conf-step__button-regular">Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
