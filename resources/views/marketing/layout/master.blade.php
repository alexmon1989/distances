<!DOCTYPE html>
<!--[if IE 9]> <html lang="ru" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <base href="{{ url('') }}/">
    <title>@yield('page_title', Memory::get('site.main_article_'.App::getLocale().'.title', ''))</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="@yield('page_description', '')" name="description">
    <meta content="" name="author">
    @yield('meta', '')

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Web Fonts -->
    <link rel="shortcut" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=cyrillic,latin">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- CSS Header and Footer -->
    <link rel="stylesheet" href="{{ asset('assets/css/headers/header-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footers/footer-v1.css') }}">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/line-icons/line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme-colors/blue.css') }}"/>

    @yield('styles')

    <!-- CSS Customization -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" media="print" href="{{ asset('assets/css/print.css') }}">
</head>

<body>
    <div class="wrapper">
        <!--=== Header Version 1 ===-->
        @include('marketing.layout._partials.header')
        <!--=== End Header Version 1 ===-->

        <!--=== Content ===-->
        <div class="container content height-500">

            @yield('content', 'Информация отсутствует')

        </div>
        <!--=== End Content ===-->

        <!--=== Footer Version 1 ===-->
        @include('marketing.layout._partials.footer')
        <!--=== End Footer Version 1 ===-->
    </div>

    <!-- JS Global Compulsory -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/plugins/back-to-top.js') }}"></script>
    <script src="{{ asset('assets/plugins/smoothScroll.js') }}"></script>

    @yield('scripts')

    <!-- JS Customization -->
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- JS Page Level -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
        });
    </script>

    <!--[if lt IE 9]>
    <script src="{{ asset('assets/plugins/respond.js') }}"></script>
    <script src="{{ asset('assets/plugins/html5shiv.js') }}"></script>
    <script src="{{ asset('assets/plugins/placeholder-IE-fixes.js') }}"></script>
    <![endif]-->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter38058175 = new Ya.Metrika({
                        id:38058175,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/38058175" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>
</html>