{{-- Popup Меню создания зала--}}
<div class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление зала
                    <a id="dismiss1" class="popup__dismiss" href="#" onclick = "cl3(id)"><img src="img/close.png" alt="Закрыть"></a>
                </h2>

            </div>
            <div class="popup__wrapper">
                <form action="{{route('admin.createHall')}}" method="POST" accept-charset="utf-8">
                    @csrf
                    {{--@method('PUT')--}}
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Название зала
                        <input class="conf-step__input" type="text" placeholder="Например, «Зал 1»" name="name" required="" @if ($open === '1') disabled @endif >
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif >
                        <button id="create_down" onclick = "cl2(id)" class="conf-step__button conf-step__button-regular" href="#" @if ($open ==='1') disabled @endif >Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
