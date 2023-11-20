{{-- Меню popup изменение фильма--}}
<div id="edit-film-{{ $film->id }}" class="popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    {{ __('Изменить фильм') }} {{ $film->title }}
                    <a id="dismiss2" class="popup__dismiss" href="" ><img src="img\close.png" alt="Закрыть"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form action="{{ route('admin.updateFilm', ['film' => $film, 'id' => $film->id]) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="title">
                        {{ __('Изменить фильм') }}
                        <input class="conf-step__input" type="text" value="{{ $film->title }}" name="title" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="description">
                       {{ __(' Описание фильма') }}
                        <input class="conf-step__input" type="text" value="{{ $film->description }}" name="description" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="duration">
                        {{ __('Длительность фильма') }}
                        <input class="conf-step__input" type="text" value="{{ $film->duration }}" name="duration" required>
                    </label>

                    <label class="conf-step__label conf-step__label-fullsize" for="origin">
                        {{ __('Страна фильма') }}
                        <input class="conf-step__input" type="text" value="{{ $film->origin }}" name="origin" required>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="imagaPath">
                        {{ __('Изображение фильма') }}
                        <input type="file" class="form-control-file" name="image_path" accept="image/png, image/jpeg">
                    </label>

                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="{{ __('Изменить фильм') }}" class="conf-step__button conf-step__button-accent">
                        <button id="cancel" class="conf-step__button conf-step__button-regular">{{ __('Отменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
