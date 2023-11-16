{{-- Popup Меню создания зала--}}
<div id="popupCreatHall" class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление зала
                    <a class="popup__dismiss" href="#"><img src="img\close.png" alt="Закрыть"></a>
                </h2>

            </div>
            <div class="popup__wrapper">
                <x-admin.form action="{{ route('admin.createHall') }}" method="post" accept-charset="utf-8">
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Название зала
                        <input class="conf-step__input" type="text" placeholder="Например Зал 1" name="name" required>
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent">
                        <button class="conf-step__button conf-step__button-regular">Отменить</button>
                    </div>
                </x-admin.form>
            </div>
        </div>
    </div>
</div>
