<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Index</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/services">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>

                <li class="nav-item ml-5">
                    <a class="nav-link" href="{{ route('giver.donations.index') }}">Donts</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('applicant.demands.index') }}">Demandes</a>
                </li>
               
                    
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else   
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <!-- We linked this to our Index Page using the Route method té5ou 
                        Comme paramétre Name Attribute éli bch tal9ah fél jadwéll 
                        Renvoyé par la commande php artisan route:list  -->
                        @can('admin-role')
                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                User Managment
                            </a>

                            <a class="dropdown-item" href="{{ route('home') }}">
                                Reservations Managment
                            </a>
                        @else
                            <a class="dropdown-item" href="/home">
                                Home
                            </a>
                        @endcan
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<script>
    function handleResetNotifications()
    {
        document.getElementById("notifications").textContent = 0;
    }
</script>