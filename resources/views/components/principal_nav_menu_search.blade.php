<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />                         
                    </a>
                    <h4 class="ml-3">{{ $title }}</h4>                    
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-link">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}">Login</a>
                @endguest
            </div>
        </div>
    </div>
    <!-- Footer -->
    <x-bulletins.public_footer></x-bulletins.public_public_footer>
</nav>
