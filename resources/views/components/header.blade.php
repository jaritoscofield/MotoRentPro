<header class="bg-white shadow-lg border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-800">MotoRentPro</h1>
            </div>
            
            <!-- User Menu -->
            @auth
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                    <i class="fas fa-user mr-2 text-gray-500"></i>
                    {{ Auth::user()->name }} 
                    <span class="text-xs text-gray-500 ml-1">({{ Auth::user()->role }})</span>
                </span>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 transition-colors duration-200 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-1"></i>Sair
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</header> 