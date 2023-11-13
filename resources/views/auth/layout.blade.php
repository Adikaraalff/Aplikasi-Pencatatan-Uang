<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style type="text/css"></style>
</head>

<body>
    <nav
        class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
        <div class="container-fluid">
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon mt-2">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="navbar-nav mx-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                                href="{{ route('login') }}">
                                <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                Sign in
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('register') }}">
                                <i class="fa fa-user opacity-6 text-dark me-1"></i>
                                Sign Up
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('lokasi_uangs.index') }}">
                                <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                Lokasi Uang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('uang_masuks.index') }}">
                                <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                Uang Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('uang_keluars.index') }}">
                                <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                Uang Keluar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('logout') }}">
                                <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                Log Out
                            </a>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>
    </nav>

    @yield('content')

</body>

</html>
