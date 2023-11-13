<header class="page-header">
    <a href="{{ route('home.index') }}"><h1 class="page-header__title">Идём<span>в</span>кино</h1></a>
   <div class="page-header__menu">
       <ul class="d-flex align-items-center gap-3 list-unstyled">
           @if(Auth::check())
               <li> <span> {{__('Вы зашли как ')}} {{ Auth::user()->name }}</span></li>
               <li><a class="menu-link {{ active_link('login') }}" href="{{ route('admin.index') }}">{{ __('Админ панель') }}</a></li>
               <li><a class="menu-link" href="{{ route('logout') }}">{{ __('Выход') }}</a></li>
           @else
               <li><a class="menu-link {{ active_link('registration') }}" href="{{ route('registration') }}">{{ __('Регистрация') }}</a></li>
               <li><a class="menu-link {{ active_link('login') }}" href="{{ route('login') }}">{{ __('Вход') }}</a></li>
           @endif
       </ul>
   </div>
</header>



