<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="pro-user-name ml-1">
                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Приветствуем!</h6>
                </div>

                <!-- item-->
                <a href="{{ route('profile.my-show') }}" class="dropdown-item notify-item">
                    <i class="remixicon-account-circle-line"></i>
                    <span>Мой профиль</span>
                </a>

                <!-- item-->
                <a href="{{ url('/to-locked') }}" class="dropdown-item notify-item">
                    <i class="remixicon-lock-line"></i>
                    <span>Заблокировать</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                    <i class="remixicon-logout-box-line"></i>
                    <span>Выйти</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('dashboard') }}" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-new.png') }}" alt="" height="60">
                <!-- <span class="logo-lg-text-dark">Minton</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-sm-text-dark">M</span> -->
                <img src="{{ asset('assets/images/logo-sm-dark.png') }}" alt="" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>

{{--        <li class="dropdown d-none d-lg-block">--}}
{{--            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">--}}
{{--                Создать--}}
{{--                <i class="mdi mdi-chevron-down"></i>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu">--}}
{{--                <!-- item-->--}}
{{--                <a href="javascript:void(0);" class="dropdown-item">--}}
{{--                    <i class="fe-briefcase mr-1"></i>--}}
{{--                    <span>Новое отделение</span>--}}
{{--                </a>--}}

{{--                <!-- item-->--}}
{{--                <a href="javascript:void(0);" class="dropdown-item">--}}
{{--                    <i class="fe-user mr-1"></i>--}}
{{--                    <span>Новую инвентаризацию</span>--}}
{{--                </a>--}}

{{--                <div class="dropdown-divider"></div>--}}

{{--                <!-- item-->--}}
{{--                <a href="javascript:void(0);" class="dropdown-item">--}}
{{--                    <i class="fe-headphones mr-1"></i>--}}
{{--                    <span>Техподдержка</span>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--        </li>--}}
    </ul>
</div>
