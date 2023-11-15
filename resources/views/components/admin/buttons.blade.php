<div class="conf-step__hall">
    <div class="conf-step__hall-wrapper">
        @for ($i = 1; $i <= $hall->{'row'}; $i++)
            <div class="conf-step__row">
                @for($j = 1; $j <= $hall->{'col'}; $j++)
                    <button onclick = "select(id)" id="{{ "$i,$j" }}" data-type='{{ json_decode($hall->{"seats_type"})->{"$i,$j"} }}' type="button" class="conf-step__chair
                    @if(json_decode($hall->{"seats_type"})->{"$i,$j"} === 'NORM')
                        conf-step__chair_standart
                    @elseif(json_decode($hall->{"seats_type"})->{"$i,$j"} === 'VIP')
                         conf-step__chair_vip
                    @elseif(json_decode($hall->{"seats_type"})->{"$i,$j"} === 'FAIL')
                         conf-step__chair_disabled
                    @endif
                   ">
                @endfor
            </div>
        @endfor
    </div>
</div>
<fieldset class="conf-step__buttons text-center">
    <button onclick = " window.location.href='{{ route('admin.index', ['selected_hall' => $hall->{'id'}]) }}' " href="#" class="conf-step__button conf-step__button-regular">Отмена</button>
    <input id="{{ $hall->{'id'} }}" onclick="editSeats(id)" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
</fieldset>
