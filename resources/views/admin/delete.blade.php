<div id="popup{{ $hall->id }}" class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Удаление зала
                    <a class="popup__dismiss" href="#"><img src="img/close.png" alt="Закрыть"></a>
                </h2>

            </div>
            <div class="popup__wrapper">
                <x-admin.form action="{{ route('admin.destroyHall', $hall->id) }}" method="delete" accept-charset="utf-8">
                    <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span>{{ $hall->name }} {{ $hall->id }}</span>?</p>
                    <!-- В span будет подставляться название зала -->
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                        <button class="conf-step__button conf-step__button-regular">Отменить</button>
                    </div>
                </x-admin.form>
            </div>
        </div>
    </div>
</div>
