<div id="addSeance-film-{{$film->id}}" class="popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
         <h2 class="popup__title">
            Добавление сеанса на фильм {{ $film->title }}
            <a id="dismiss3" class="popup__dismiss" href="" ><img src="img/close.png" alt="Закрыть"></a>
         </h2>
      </div>
      <div class="popup__wrapper">
          <form action="{{ route('admin.createSeance') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" name="seance{{$film->id}}" >
              @csrf
          <label class="conf-step__label conf-step__label-fullsize" for="hall">
            Название зала
            <select id="select_hall" class="conf-step__input" name="hall_id" required>
                @php
                    $i=1;
                @endphp
                @foreach ($halls as $hall)
                  @if($i==1)
                    <option value="{{$hall->id}}" selected>{{$hall->name}}</option>
                  @else
                    <option value="{{$hall->id}}">{{$hall->name}}</option>
                    @php
                        $i++;
                    @endphp
                  @endif
               @endforeach
            </select>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="name">
            Время начала
            <input id="time" class="conf-step__input" type="time" value="00:00:00" name="seance_start" step="10" required>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="name">
              Дата
            <input id="time" class="conf-step__input" type="date"  name="seance_date" required>
          </label>
              <input style="display: none;" name="film_id" value="{{ $film->id }}">
          <div class="conf-step__buttons text-center">
              <input  id="{{ $film->id }}" type="submit" value="Добавить" class="conf-step__button conf-step__button-accent" >
              <button  id="{{$film->id}}"  onclick = " window.location.href='{{ route('admin.index') }}' " href="#" class="conf-step__button conf-step__button-regular" >Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
