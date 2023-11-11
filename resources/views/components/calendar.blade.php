@php
    $days = ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"];
@endphp

@php
    $isAll = true;
@endphp

<nav class="page-nav">
    @for ($i = 0; $i < 6; $i++)
        @switch($i)
            @case(0)
                @if(Carbon\Carbon::createFromDate($dateCurrent)->day !== Carbon\Carbon::now()->day)
                    @php
                        $isToday = false;
                    @endphp
                @else
                    @php
                        $isToday = true;
                    @endphp
                @endif
                @if(Carbon\Carbon::createFromDate($dateChosen)->dayOfWeek - Carbon\Carbon::createFromDate($dateCurrent)->dayOfWeek === 0 && Carbon\Carbon::createFromDate($dateChosen)->day - Carbon\Carbon::createFromDate($dateCurrent)->day === 0)
                    <a @class(['page-nav__day'=>$isAll, 'page-nav__day_today'=>$isToday, 'page-nav__day_chosen'=>$isAll])
                       href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10)])}}">
                        <span class="page-nav__day-week">{{$days[Carbon\Carbon::createFromDate($dateCurrent)->dayOfWeek]}}</span>
                        <span class="page-nav__day-number">{{Carbon\Carbon::createFromDate($dateCurrent)->day}}</span>
                    </a>
                    @break
                @else
                    <a @class(['page-nav__day'=>$isAll, 'page-nav__day_today'=>$isToday])
                       href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10)])}}">
                        <span class="page-nav__day-week">{{$days[Carbon\Carbon::createFromDate($dateCurrent)->dayOfWeek]}}</span>
                        <span class="page-nav__day-number">{{Carbon\Carbon::createFromDate($dateCurrent)->day}}</span>
                    </a>
                    @break
                @endif
            @default
                @if(Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->dayOfWeek ===0 || Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->dayOfWeek ===6 )
                    @php
                        $isWeekend = true;
                    @endphp
                @else
                    @php
                        $isWeekend = false;
                    @endphp
                @endif
                @if(abs(Carbon\Carbon::createFromDate($dateChosen)->dayOfWeek-Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->dayOfWeek) === 0 && abs(Carbon\Carbon::createFromDate($dateChosen)->dayOfWeek - Carbon\Carbon::createFromDate($dateCurrent)->dayOfWeek) > 0 &&  abs(Carbon\Carbon::createFromDate($dateChosen)->dayOfWeek - Carbon\Carbon::createFromDate($dateCurrent)->dayOfWeek)<=5 )
                    <a @class(['page-nav__day'=> $isAll, 'page-nav__day_chosen'=> $isAll, 'page-nav__day_weekend' => $isWeekend]) href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays($i), 0, 10)])}}">
                        <span class="page-nav__day-week">{{$days[Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->dayOfWeek]}}</span>
                        <span class="page-nav__day-number">{{Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->day}}</span>
                    </a>
                @else
                    <a @class(['page-nav__day'=>$isAll, 'page-nav__day_weekend' => $isWeekend ]) href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays($i), 0, 10)])}}">
                        <span class="page-nav__day-week">{{$days[Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->dayOfWeek]}}</span>
                        <span class="page-nav__day-number">{{Carbon\Carbon::createFromDate($dateCurrent)->addDays($i)->day}}</span>
                    </a>
                @endif
        @endswitch
    @endfor
    @if(abs(Carbon\Carbon::createFromDate($dateCurrent)->day - Carbon\Carbon::now()->day) >=6)
        <a class="page-nav__day page-nav__day_prev" href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays(-6), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays(-6), 0, 10)])}}"></a>
    @else
        <a class="page-nav__day page-nav__day_next" href="{{ route('home.index', ['films' => $films, 'halls' => $halls, 'seances'=> $seances, 'dateCurrent' => substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays(6), 0, 10), 'dateChosen'=> substr(Carbon\Carbon::createFromDate($dateCurrent)->addDays(6), 0, 10)])}}"></a>
    @endif
</nav>
