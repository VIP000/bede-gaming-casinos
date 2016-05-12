<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf-token">

    <title>Laravel</title>

    <!-- Styles -->
    <link href="{{ elixir("css/app.css") }}" rel="stylesheet">

    <script>
        var app = {
            debug: {{ app()->environment("dev", "development", "local") ? "true" : "false" }},
            environment: '{{ app()->environment() }}',
            userId: {{ Auth::guest() ? "false" : Auth::user()->id }},
            name: '{{ Auth::guest() ? "" : Auth::user()->name }}',
            apiToken: {!! Auth::guest() ? "null" : "'" . Auth::user()->api_token . "'" !!},
            isAdmin: {{ Auth::guest() ? "false" : (Auth::user()->isAdmin() ? "true" : "false") }},
            csrfToken: '{{ csrf_token() }}',
        };

        var NotificationStore = {
            state: [], // here the notifications will be added

            addNotification: function (notification) {
                this.state.push(notification)
            },

            removeNotification: function (notification) {
                this.state.$remove(notification)
            },
        };
    </script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route("home") }}">
                    Bede Gaming Casino Locator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li>
                        <a v-link="{ name: 'home' }">
                            Home
                        </a>
                    </li>

                    {{-- <li>
                        <a v-link="{ name: 'search' }">
                            Search
                        </a>
                    </li> --}}

                    @if (!Auth::guest() && Auth::user()->isAdmin())
                        <li>
                            <a v-link="{ name: 'new-casino' }">
                                Add New Casino
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li>
                            <a href="{{ url("/login") }}">
                                Login
                            </a>
                        </li>

                        <li>
                            <a href="{{ url("/register") }}">
                                Register
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url("/logout") }}">
                                        <i class="fa fa-btn fa-sign-out"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div id="app">
        @yield('content')
    </div>

    <div id="notifications">
        <notifications></notifications>
    </div>

    <!-- JavaScripts -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzlLYISGjL_ovJwAehh6ydhB56fCCpPQw&libraries=places"></script>
    <script src="/js/app.js"></script>
    {{-- <script src="{{ elixir("js/app.js") }}"></script> --}}
</body>
</html>
