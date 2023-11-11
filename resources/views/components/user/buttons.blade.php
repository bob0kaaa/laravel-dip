<div class="buying-scheme">
    <div class="buying-scheme__wrapper">
        @for ($i = 1; $i <= $hall['row']; $i++)
            <div class="buying-scheme__row">
                {{$seats}}
                @foreach ($seats->where('row_number', $i) as $item)
                    @if(!$item['free'])
                        <button onclick = "cl(id)" id="{{$item['row_number']}},{{$item['col_number']}}" type="button" class="buying-scheme__chair buying-scheme__chair_taken">
                    @else
                        @php
                            $ij = $item['row_number'].",".$item['col_number'];
                        @endphp
                        @switch(json_decode($hall['seats_type'])->{$ij})
                            @case('VIP')
                                <button onclick = "cl(id)" id="{{$item['row_number']}},{{$item['col_number']}}" type="button" class="buying-scheme__chair buying-scheme__chair_vip">
                                @break
                            @case('FAIL')
                                <button id="{{$item['row_number']}},{{$item['col_number']}}" type="button" class="buying-scheme__chair buying-scheme__chair_disabled">
                                @break
                            @default
                                <button onclick = "cl(id)" id="{{$item['row_number']}},{{$item['col_number']}}" type="button" class="buying-scheme__chair buying-scheme__chair_standart">
                        @endswitch
                    @endif
                @endforeach
            </div>
        @endfor
    </div>

    <div class="buying-scheme__legend">
        <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{$hall['count_normal']}}</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{$hall['count_vip']}}</span>руб)</p>
        </div>
        <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
        </div>
    </div>
</div>
<button id="booking" class="acceptin-button">Забронировать</button>
<script>
     function cl(id){
        if(!(document.getElementById(id).classList.contains('buying-scheme__chair_disabled') || document.getElementById(id).classList.contains('buying-scheme__chair_taken'))) {
            document.getElementById(id).classList.toggle('buying-scheme__chair_selected');
        }
    }

    let btnBooking = document.querySelector('#booking');
    btnBooking.addEventListener('click', () => {
        const selected = [];
        Array.of(document.querySelectorAll('button.buying-scheme__chair_selected')).forEach((element, index, array) => {
            for(let i=0; i<element.length; i++) {
                selected.push(element[i].id);
            }

            const json=JSON.stringify(selected);

            let url = "{{route('user.seat', ['hall'=> $hall, 'seance'=> $seance, 'film'=> $film, 'dateChosen'=> $dateChosen, 'seats'=> $seats->where('hall_id', $hall['id'])->where('seance_id', $seance['id']), 'selected' => 'json'])}}";
            url = url.replace('json', json);
            url = url.replaceAll('&amp;', '&');
            window.location.href = url;
        });
    });
</script>
