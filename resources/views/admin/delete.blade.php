<div id="popup{{$hall->id}}" class="popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
            Удаление зала
            <a id="{{$hall->id}}" class="popup__dismiss" onclick = "popupToggle(id)"  href="#"><img src="img/close.png" alt="Закрыть"></a>
        </h2>
      </div>
      <div  class="popup__wrapper">
        <form action="{{ route('admin.destroyHall', ['id' => $hall->id]) }}" method="post" accept-charset="utf-8">
            @csrf
            @method('DELETE')
            <p class="conf-step__paragraph">Вы действительно хотите удалить зал: <span>"{{$hall->name}}"</span>?</p>
                <!-- В span будет подставляться название зала -->
            <div class="conf-step__buttons text-center">
            <input  type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button id="{{$hall->id}}" class="conf-step__button conf-step__button-regular" onclick ="event.preventDefault();popupToggle(id)" >Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
