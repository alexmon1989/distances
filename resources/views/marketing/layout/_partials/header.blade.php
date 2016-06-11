<div class="header">
    <div class="container">
        <!-- Logo -->
        <a class="logo" href="{{ url('/') }}">
            <img src="{{ url('assets/img/logo1-default.png') }}" alt="Logo">
        </a>
        <!-- End Logo -->

        <!-- Top Bar -->
        <div class="topbar">
            <ul class="loginbar pull-right">
                <li class="hoverSelector">
                    <i class="fa fa-globe"></i>
                    <a>{{ Lang::get('interface.change_lang') }}</a>
                    <ul class="languages hoverSelectorBlock">
                        <li class="{{ App::getLocale() == 'ru' ? 'active' : '' }}">
                            <a rel="alternate" hreflang="ru" href="{{LaravelLocalization::getLocalizedURL('ru') }}">{{ Lang::get('interface.russian') }} {!! App::getLocale() == 'ru' ? '<i class="fa fa-check"></i>' : '' !!}</a>
                        </li>
                        <li class="{{ App::getLocale() == 'uk' ? 'active' : '' }}">
                            <a rel="alternate" hreflang="uk" href="{{LaravelLocalization::getLocalizedURL('uk') }}">{{ Lang::get('interface.ukrainian') }} {!! App::getLocale() == 'uk' ? '<i class="fa fa-check"></i>' : '' !!}</a>
                        </li>
                        <li class="{{ App::getLocale() == 'en' ? 'active' : '' }}">
                            <a rel="alternate" hreflang="en" href="{{LaravelLocalization::getLocalizedURL('en') }}">{{ Lang::get('interface.english') }} {!! App::getLocale() == 'en' ? '<i class="fa fa-check"></i>' : '' !!}</a>
                        </li>
                        <li class="{{ App::getLocale() == 'pl' ? 'active' : '' }}">
                            <a rel="alternate" hreflang="en" href="{{LaravelLocalization::getLocalizedURL('pl') }}">{{ Lang::get('interface.polish') }} {!! App::getLocale() == 'pl' ? '<i class="fa fa-check"></i>' : '' !!}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Top Bar -->

        <!-- Toggle get grouped for better mobile display -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
        </button>
        <!-- End Toggle -->
    </div><!--/end container-->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
        <div class="container">
            <ul class="nav navbar-nav">
                <!-- Верхнее меню -->
                <li class="{{ \Request::route()->getName() == 'index' ? 'active' : '' }}"><a href="{{ route('index') }}">{{ Lang::get('interface.menu.main') }}</a></li>
                <li class="{{ in_array(\Request::route()->getName(), ['cities_index', 'cities_show']) ? 'active' : '' }}"><a href="{{ route('cities_index') }}">{{ Lang::get('interface.menu.cities') }}</a></li>
                <li class="{{ \Request::route()->getName() == 'about' ? 'active' : '' }}"><a href="{{ route('about') }}">{{ Lang::get('interface.menu.about') }}</a></li>
                <!-- End Верхнее меню -->
            </ul>
        </div><!--/end container-->
    </div><!--/navbar-collapse-->
</div>