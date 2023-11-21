@extends('layouts.base')
@section('content')
    <section class="ticket">
        <header class="tichet__check">
            <h2 class="ticket__check-title">Электронный билет</h2>
        </header>
        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{$film['title']}}</span></p>
            <p class="ticket__info">Места:
                @php
//                    dd($selected);
                @endphp
                @foreach (json_decode($selected) as $item)
                    <span class="ticket__details ticket__chairs"> {{'ряд:'}} {{explode(',',$item)[0]}} {{'место:'}} {{explode(',',$item)[1]+(explode(',',$item)[0]-1)*$hall['col']}} {{','}} </span>
                @endforeach
            </p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{$hall['id']}}</span></p>
            <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{substr($seance['seance_start'], -8, 5)}}</span></p>
            <p class="ticket__info">Стоимость билета: <span class="ticket__details ticket__hall">{{$count}}{{' руб.'}}</span></p>
            @php
//            dd($qrCode);
                $url = base_path() . '\public\qr\qr.png';
                require_once base_path() . '\phpQrCode\qrlib.php';
                QrCode::png($qrCode, base_path() . '\public\qr\qr.png', 'H', 48, 2);
              echo '<img class="ticket__info-qr" src="\qr\qr.png" alt="$qrCode">';

            @endphp
            <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
            <p class="ticket__hint">Приятного просмотра!</p>
            <div style="display: flex; justify-content: center;">
                <a href="{{ route('home.index') }}" class="acceptin-button" style="display: inline-block; margin: 0 auto;">На главную</a>
            </div>
        </div>
    </section>
@endsection
