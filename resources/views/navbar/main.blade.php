<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('navbar/styles')

    <body class="sb-nav-fixed">
        @include('navbar/nav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid ps-1 pe-4" style="padding-top:60px;">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        @include('navbar/scripts')

    </body>
</html>
