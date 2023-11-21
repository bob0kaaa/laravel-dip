@extends('layouts.base')

@section('nav')
   <x-calendar :seances="$seances" :halls="$halls" :films="$films" dateCurrent="{{$dateCurrent}}" dateChosen="{{$dateChosen}}" />
@endsection
@section('content')
    @if(empty($films))
        <h2>
            {{ __('На эту дату нет фильмов') }}
        </h2>
    @else
        @foreach($films as $film)
              <x-film.card :film="$film" :halls="$halls" :seances="$seances" :seats="$seats" dateCurrent="{{$dateCurrent}}" dateChosen="{{$dateChosen}}" />
        @endforeach
    @endif
@endsection

