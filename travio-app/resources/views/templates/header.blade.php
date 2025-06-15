    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav mt-3">
        <div class="container">

            <div class="site-navigation">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <a href="index.html" class="logo m-0 float-start">Travio</a>
                    </div>
                    <div class="col-lg-6 d-none d-lg-inline-block text-center nav-center-wrap">
                        <ul class="js-clone-nav  text-center site-menu p-0 m-0">
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('search')}}">Search</a></li>
                            <li><a href="#">About Us</a></li>
                            @auth
                                <li><a href="{{route('trips.index')}}">Trips</a></li>
                                <li><a href="{{route('chats.index')}}">Chats</a></li>
                                <li><a href="{{route('friends.index')}}">Friends</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="col-6 col-lg-3 text-lg-end">
                        @auth
                            <ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu ">
                                <li class="cta-button"><a href="{{route('profile.show', auth()->id())}}">To Profile</a></li>
                   
                            </ul>
                        @endauth

                        @guest
                            <ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu ">
                                <li class="cta-button"><a href="{{ route('login') }}">Login</a></li>
                            </ul>
                        @endguest
                        <a href="#"
                            class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light"
                            data-toggle="collapse" data-target="#main-navbar">
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </nav>
