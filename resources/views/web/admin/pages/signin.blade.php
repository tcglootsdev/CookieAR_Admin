<!DOCTYPE html>
<html lang="en">
<head>
    <title>CookieAR Service | Sign In</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="{{ URL::asset('assets/web/admin/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/web/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/web/admin/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<body id="kt_body" class="auth-bg">
<script>
    const defaultThemeMode = "light";
    let themeMode;
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
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    <form class="form w-100 pg-signin-form">
                        @csrf
                        <div class="text-center mb-10">
                            <h1 class="text-gray-900 mb-3">CookieAR Admin</h1>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bold text-gray-900">Username</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="username"
                                   autocomplete="off"/>
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                   name="password" autocomplete="off"/>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Sign In</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const hostUrl = "{{ URL::asset('assets/')}}";
    const csrf_token = '{{ csrf_token() }}';
</script>
<script src="{{ URL::asset('assets/web/admin/js/plugins.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/web/admin/js/scripts.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/web/global/js/app.js') }}"></script>
<script src="{{ URL::asset('assets/web/admin/plugins/jquery-validation-1.19.5/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('assets/web/admin/plugins/jquery-validation-1.19.5/additional-methods.min.js') }}"></script>
<script src="{{ URL::asset('assets/web/admin/js/pages/signin.js') }}"></script>
<script src="{{ URL::asset('assets/web/admin/js/app.js') }}"></script>
</body>
</html>
