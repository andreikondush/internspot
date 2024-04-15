<header @if(Route::currentRouteName() == 'home') class="float" @endif>
    <div class="container">
        <a href="{{ route('home') }}" id="logo">
            InternSpot
            @if($isAdmin)
                <div class="isAdmin">Admin</div>
            @endif
        </a>
        @if(Route::currentRouteName() != 'home')
            <ul class="menu">
                <li class="item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                @if(auth('user')->check())
                    <li class="item @if(Route::currentRouteName() == 'internships.list') active @endif">
                        <a href="{{ route('internships.list') }}">Internships</a>
                    </li>
                    @if($isAdmin)
                        <li class="item @if(Route::currentRouteName() == 'cities.list') active @endif">
                            <a href="{{ route('cities.list') }}">Cities</a>
                        </li>
                        <li class="item @if(Route::currentRouteName() == 'companies.list') active @endif">
                            <a href="{{ route('companies.list') }}">Companies</a>
                        </li>
                        <li class="item @if(Route::currentRouteName() == 'tags.list') active @endif">
                            <a href="{{ route('tags.list') }}">Tags</a>
                        </li>
                    @endif
                    <li class="item logout">
                        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                @endif
            </ul>
        @else
            <div class="next">
                @if(auth('user')->check())
                    <a href="{{ route('internships.list') }}"><i class="fas fa-clipboard-list"></i> Internships</a>
                    <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                @else
                    <a href="{{ route('authorization') }}"><i class="fas fa-sign-in-alt"></i> Sign in</a>
                    <a href="{{ route('registration') }}"><i class="fas fa-user-plus"></i> Sign up</a>
                @endif
            </div>
        @endif
    </div>
</header>
