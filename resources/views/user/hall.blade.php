@extends('layouts.base')

@section('content')
    @php
        $selected = [];
    @endphp
    <main>
        <section class="buying">
            <div class="buying__info">
                <div class="buying__info-description">
                    <h2 class="buying__info-title">{{$film['title']}}</h2>
                    <p class="buying__info-start">{{ __('Начало сеанса')}}: {{substr($seance['seance_start'],-8,5)}}</p>
                    <p class="buying__info-hall">{{$hall['name']}}</p>
                </div>
                <div class="buying__info-hint">
                    <p>{{ __('Тапните дважды') }},<br>{{ __('чтобы увеличить') }}</p>
                </div>
            </div>
            <x-user.buttons :seats="$seats" :seance="$seance" :film="$film" :hall="$hall"  dateChosen="{{$dateChosen}}" :selected="$selected">
            </x-user.buttons>
        </section>
    </main>
@endsection
