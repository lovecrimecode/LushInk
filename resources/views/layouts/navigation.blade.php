<nav class="bg-paper border-b border-gray-800 mb-8">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-xl font-bold text-wine">LushInk</a>

        <div class="space-x-6">
            <a href="/" class="hover:text-wine">Search</a>

            @auth
                <a href="/library" class="hover:text-wine">My Library</a>
                <span class="text-gray-400">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-wine">Logout</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="hover:text-wine">Login</a>
                <a href="{{ route('register') }}" class="hover:text-wine">Register</a>
            @endguest
        </div>
    </div>
</nav>
