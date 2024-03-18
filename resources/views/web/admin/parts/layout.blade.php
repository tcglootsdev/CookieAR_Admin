@php
    $user = Auth::guard('web')->user();
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>CookieAR Service | {{ $title }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="{{ URL::asset('assets/web/admin/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/web/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/web/admin/css/app.css') }}" rel="stylesheet" type="text/css"/>
    @stack('styles')
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<body id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div id="kt_aside" class="aside aside-default aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
             data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
             data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
             data-kt-drawer-toggle="#kt_aside_toggle">
            <div class="aside-logo flex-column-auto px-10 pt-9 pb-5" id="kt_aside_logo">
            </div>
            @include('web.admin.parts.menu')
        </div>
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('web.admin.parts.header', ['user' => $user])
            <div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">
                @yield('content')
            </div>
            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                    <div class="text-gray-900 order-2 order-md-1">
                        <span class="text-muted fw-semibold me-2">{{ date('Y') }}&copy;CookieAR</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('modals')
@stack('drawers')
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
</div>
<script>
    var hostUrl = "{{ URL::asset('/')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/plugins.bundle.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/scripts.bundle.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/web/global/js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/parts/menu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/parts/header.js') }}"></script>
@include('web.admin.parts.csrf-token')
@stack('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/app.js') }}"></script>
</body>
</html>
