<nav class="nav-container">
    <div class="nav-content">
        <div class="nav-left">
            <a href="{{ route('welcome') }}" class="nav-logo">
                E-Voting
            </a>
        </div>

        <div class="nav-right hidden md:flex">
            <a href="{{ route('welcome') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                Home
            </a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                About
            </a>
            <a href="#" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                Contact Us
            </a>
            <a href="#" class="nav-link {{ request()->is('faq') ? 'active' : '' }}">
                FAQ
            </a>

            <div class="nav-spacer"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="nav-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-login">
                    Login
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-button" class="md:hidden mobile-menu-button" aria-label="Toggle menu">
            <svg class="w-8 h-8" fill="none" stroke="#0061A1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu hidden md:hidden">
        <a href="{{ route('welcome') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
            Home
        </a>
        <a href="{{ route('about') }}" class="mobile-nav-link {{ request()->is('about') ? 'active' : '' }}">
            About
        </a>
        <a href="#" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">
            Contact Us
        </a>
        <a href="#" class="mobile-nav-link {{ request()->is('faq') ? 'active' : '' }}">
            FAQ
        </a>
        @auth
            <a href="{{ url('/dashboard') }}" class="nav-login">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="nav-login">
                Login
            </a>
        @endauth
    </div>
</nav>
