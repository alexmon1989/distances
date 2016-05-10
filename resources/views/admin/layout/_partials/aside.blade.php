<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/plugins/adminlte/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Главная навигация</li>
            <li class="{{ Request::segment(2) == 'dashboard' || Request::segment(2) == '' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Начало работы</span>
                </a>
            </li>
            <li class="{{ Request::segment(2) == 'users' ? 'active' : '' }}">
                <a href="{{ route('users') }}">
                    <i class="fa fa-users "></i> Пользователи (админы)
                </a>
            </li>
            <li class="{{ Request::segment(2) == 'settings' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Настройки</span>
                </a>
            </li>

            <li class="header">Страницы сайта</li>
            <li class="{{ Request::segment(2) == 'pages' && Request::segment(2) == 'main' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-home"></i> <span>Главная</span>
                </a>
            </li>
            <li class="{{ Request::segment(2) == 'pages' && Request::segment(2) == 'cities' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-list-alt"></i> <span>Список городов</span>
                </a>
            </li>
            <li class="{{ Request::segment(2) == 'pages' && Request::segment(2) == 'about' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>Про сервис</span>
                </a>
            </li>

            <li class="header">Ссылки</li>
            <li>
                <a href="{{ route('index') }}" title="Открыть в новой вкладке" target="_blank">
                    <i class="fa fa-external-link"></i> <span>Перейти на сайт</span>
                </a>
            </li>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>