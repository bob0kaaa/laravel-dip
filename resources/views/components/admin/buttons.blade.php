<div class="conf-step__hall">
    <div class="conf-step__hall-wrapper">
        @for ($i = 1; $i <= $hall->{'row'}; $i++)
            <div class="conf-step__row">
                @for($j = 1; $j <= $hall->{'col'}; $j++)

                    <button onclick = "select(id)" id="{{ "$i,$j"}}" data-type='{{ json_decode($hall->{"seats_type"})->{"$i,$j"} }}' type="button"   class="conf-step__chair conf-step__chair_vip" @if ($open === '1') disabled @endif>
                @endfor
            </div>
        @endfor
    </div>
</div>
<fieldset class="conf-step__buttons text-center">
    <button onclick = " window.location.href='{{ route('admin.index', ['confStep'=> ['conf-step__header_closed',  'conf-step__header_opened', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed'],'open'=> $open,'selected_hall' => $hall->{'id'}]) }}' " href="#" class="conf-step__button conf-step__button-regular" @if ($open === '1') disabled @endif>Отмена</button>
    <input id="{{ $hall->{'id'} }}" onclick="editSeats(id)" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @if ($open === '1') disabled @endif>
</fieldset>
