<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Навигация</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="remixicon-dashboard-line"></i>
                        <span> Главная </span>
                    </a>
                </li>
{{--                @hasanyrole('Super Admin|Client')--}}
                <li>
                    <a href="{{ route('branch.index') }}" class="waves-effect">
                        <i class="remixicon-layout-line"></i>
                        <span> Отделения </span>
                    </a>
                </li>
{{--                @endhasanyrole--}}
                <li>
                    <a href="{{ route('inventory.index') }}" class="waves-effect">
                        <i class="remixicon-layout-line"></i>
                        <span> Инвентаризации </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.index') }}" class="waves-effect">
                        <i class="remixicon-layout-line"></i>
                        <span> Категории </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('teams.index') }}" class="waves-effect">
                        <i class="remixicon-layout-line"></i>
                        <span> Команды </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-mail-open-line"></i>
                        <span> Создать </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="email-compose.html">Новое отделение</a>
                        </li>
                        <li>
                            <a href="email-read.html">Новая инвентаризация</a>
                        </li>
                        <li>
                            <a href="email-inbox.html">Новая категория</a>
                        </li>
                        <li>
                            <a href="{{route('teams.create')}}">Новая команда</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title mt-2">Components</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-folder-add-line"></i>
                        <span> Multi Level </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);">Level 1.1</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false">Level 1.2
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-third-level nav" aria-expanded="false">
                                <li>
                                    <a href="javascript: void(0);">Level 2.1</a>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">Level 2.2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
