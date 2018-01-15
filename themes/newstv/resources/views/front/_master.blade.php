<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <title>{{ $pageTitle or '' }} - {{ get_setting('site_title', 'Medisum') ?: 'Medisum' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {!! seo()->render() !!}

    <script>
        var BASE_URL = '{{ asset('') }}';
    </script>
    <base href="{{ asset('') }}">
    <meta name="google-site-verification" content="{{ get_theme_option('google_site_verification') }}"/>
    <!--<link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style.css') }}">
    @foreach(config('sgsoft-themes.' . (get_theme_option('theme_layout', 'red') ?: 'red') . '.css') as $css)
        <link rel="stylesheet" href="{{ asset($css) }}">
    @endforeach
    <link id="style_color" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style/init.css') }}"/>
    <link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style/lazy.css') }}"/>
    <link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style/public.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/news-tv/dist/style/responsive1203.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/news-tv/dist/style/responsive768.css') }}"/>   
    @php do_action('front_header_css') @endphp
    @yield('css')
    @stack('css')
    @php do_action('front_header_js') @endphp
</head>
<body class="{{ $bodyClass or '' }} @php do_action('front_body_class') @endphp">
		@yield('move')
		<div class="outer_continer">
			@include('webed-theme::front._partials.header')
			@yield('content')
			@include('webed-theme::front._partials.footer')
		</div>
<!--<script src="{{ asset('themes/news-tv/third_party/modernizr.js') }}"></script>
<script type="text/javascript"
        src="//platform-api.sharethis.com/js/sharethis.js#property=58b80e5cfacf57001271be31&product=sticky-share-buttons"></script>
<script src="{{ asset('themes/news-tv/dist/core.min.js') }}"></script>
<script src="{{ asset('themes/news-tv/dist/app.min.js') }}"></script>
@php do_action('front_footer_js') @endphp-->
@yield('js')
<script src="{{ asset('themes/news-tv/dist/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('themes/news-tv/dist/js/lazy.js') }}"></script>
<script src="{{ asset('themes/news-tv/dist/js/public.js') }}"></script>
<script src="{{ asset('themes/news-tv/dist/js/index.js') }}"></script>
<!--@stack('js')
@yield('js-init')
@stack('js-init')-->
<div id="fb-root"></div>
<!--<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=867766230033521";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>-->

</body>

</html>
