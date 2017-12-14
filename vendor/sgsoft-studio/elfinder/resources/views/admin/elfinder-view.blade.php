<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CMS File Browser</title>

    <link rel="stylesheet" href="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.css') }}"/>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/modules/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/modules/elfinder/css/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/modules/elfinder/themes/moono/css/theme.css') }}">
    <style>
        html body.show-admin-bar,
        body {
            padding: 0 !important;
            margin : 0 !important;
            border: 1px solid #ccc;
        }
        .embed-responsive-16by9 {
            padding-bottom : 56.25% !important;
        }

        .embed-responsive {
            position : relative;
            display  : block;
            height   : 0;
            padding  : 0;
        }

        .embed-responsive .embed-responsive-item,
        .embed-responsive embed,
        .embed-responsive iframe,
        .embed-responsive object,
        .embed-responsive video {
            position : absolute;
            top      : 0;
            left     : 0;
            bottom   : 0;
            height   : 100% !important;
            width    : 100% !important;
            border   : 0;
        }
        #admin_bar,
        .phpdebugbar {
            display : none !important;
        }
        .elfinder .elfinder-contextmenu,
        .elfinder .elfinder-contextmenu-sub {
            padding: 0;
        }
        .elfinder .elfinder-contextmenu-ltr .elfinder-contextmenu-icon {
            left : 0;
        }
    </style>
    <script type="text/javascript">
        var BASE_URL = '{{ asset('') }}';
    </script>
</head>
<body>
<!-- Element where elFinder will be created (REQUIRED) -->
<div class="embed-responsive embed-responsive-16by9">
    <div id="elfinder" class="embed-responsive-item"></div>
</div>

<!-- jQuery and jQuery UI (REQUIRED) -->
<script src="{{ asset('admin/plugins/jquery.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/js/webed-core.js') }}"></script>
<!-- elFinder JS (REQUIRED) -->
<script src="{{ asset('admin/modules/elfinder/js/elfinder.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    var baseUrl = '{{ asset('') }}';
    var selectMethod = '{{ Request::get('method', 'standalone') }}';
    var fileType = '{{ Request::get('type', 'image') }}';
    var funcNum = '{{ Request::get('CKEditorFuncNum') }}';

    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
        var match = window.location.search.match(reParam);

        return (match && match.length > 1) ? match[1] : '';
    }

    $(document).ready(function () {
        $('#elfinder').elfinder({
            // set your elFinder options here
            customData: {
                _token: '{{ csrf_token() }}'
            },
            soundPath: '{{ asset('admin/modules/elfinder/sounds') }}',
            url: '{{ route('admin::elfinder.connect') }}',
            @if(Request::get('type', 'image') != 'file')
            //onlyMimes: ["image", "image/svg+xml"],
            @endif
            getFileCallback: function (file) {
                var URL = file.url.replace(baseUrl, '/');
                if (selectMethod == "ckeditor") {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, Helpers.asset(URL));
                    window.close();
                }
                if (selectMethod == 'standalone') {
                    $modal = window.parent.document.mediaModal;
                    $target = window.parent.document.currentMediaBox;
                    if (fileType == 'file') {
                        $target.find('a .title').html(Helpers.asset(URL));
                    }
                    else {
                        $target.find('.img-responsive').attr('src', Helpers.asset(URL));
                    }

                    $target.find('.input-file').val(URL);
                    $modal.find('iframe').remove();
                    $modal.modal('hide');
                }
            }
        });
    });
</script>
</body>
</html>
