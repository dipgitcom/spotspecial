<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Codescandy" />
    <title>@yield('title', 'Dashboard') | Dash UI</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="" type="image/x-icon" />

    <!-- Global Styles -->
    @include('backend.partials.style')

    <!-- Page Specific Styles -->
    @stack('styles')
</head>

<body>
    @yield('login')
    <main id="main-wrapper" class="main-wrapper">

        @unless (Route::is(['login', 'register']))
            @include('backend.partials.header')
            @include('backend.partials.sidebar')
        @endunless

        <div id="app-content">
            <div class="app-content-area">
                <!-- Optional top spacing -->
                <div class="pt-10 pb-21 mt-n6 mx-n4"></div>

                <!-- Main Container -->
                <div class="container-fluid mt-n22">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    @unless (Route::is('login'))
        @include('backend.partials.script')
    @endunless

    <!-- Page Specific Scripts -->
    @stack('scripts')

</body>

</html>
