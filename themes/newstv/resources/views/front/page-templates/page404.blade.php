<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <title>{{ $pageTitle or '' }} - {{ get_setting('site_title', 'WebEd') ?: 'WebEd' }}</title>

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
    <link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style/init.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/news-tv/dist/style/public.css') }}">
    @php do_action('front_header_css') @endphp
    @yield('css')
    @stack('css')
    @php do_action('front_header_js') @endphp
</head>
<body class="{{ $bodyClass or '' }} @php do_action('front_body_class') @endphp" overflow="hidden">
	<div class="bug_continer">
		<div class="content">
			<ul class="content_pic">
				<li class="fl pic_1 item"></li>
				<li class="fl pic_2 item"></li>
				<li class="fl pic_3 item"></li>
				<li class="clear"></li>
			</ul>
			<p class="tl_center">
				此页面不存在或者无法找到
				</br>
				本页面将在6s后自动跳转到<a href="../home">首页</a>
			</p>
			<div class="advice">
				<h4>建议</h4>
				<p>
					检查你的网络是否正确<br/>
					检查您是否使用了错误的网址连接
				</p>
			</div>
			
		</div>

	</div>
	<script src="{{ asset('themes/news-tv/dist/js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('themes/news-tv/dist/js/index.js') }}"></script>
	<!--@stack('js')
	@yield('js-init')
	@stack('js-init')-->
	<div id="fb-root"></div>
</body>
</html>