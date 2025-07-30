<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MotoRentPro')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar Toggle for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center justify-between h-14 px-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-motorcycle text-gray-700 text-lg mr-2"></i>
                <span class="text-gray-800 font-bold text-base">MotoRentPro</span>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-4 px-3">
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2 text-xs"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="/frota" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm {{ request()->routeIs('motorcycles.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                    <i class="fas fa-motorcycle mr-2 text-xs"></i>
                    <span>Gestão de Frota</span>
                </a>
                
                <a href="/reservas" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm">
                    <i class="fas fa-calendar-alt mr-2 text-xs"></i>
                    <span>Reservas</span>
                </a>
                
                <a href="/clientes" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm">
                    <i class="fas fa-users mr-2 text-xs"></i>
                    <span>Clientes</span>
                </a>
                
                <a href="/manutencao" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm">
                    <i class="fas fa-tools mr-2 text-xs"></i>
                    <span>Manutenção</span>
                </a>
                
                <a href="#" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm">
                    <i class="fas fa-chart-bar mr-2 text-xs"></i>
                    <span>Relatórios</span>
                </a>
                
                <a href="#" class="flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors duration-200 text-sm">
                    <i class="fas fa-cog mr-2 text-xs"></i>
                    <span>Configurações</span>
                </a>
            </div>
        </nav>
        
        <!-- User Info -->
        <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-7 h-7 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-xs"></i>
                    </div>
                </div>
                <div class="ml-2">
                    <p class="text-xs font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Topbar -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between h-14 px-4 sm:px-6 lg:px-8">
                <!-- Mobile menu button -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <!-- Page title -->
                <div class="flex-1 lg:flex-none">
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <!-- Right side -->
                <div class="flex items-center space-x-3">
                    <!-- Notifications -->
                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-bell text-base"></i>
                    </button>
                    
                    <!-- Profile dropdown -->
                    <div class="relative">
                        <button onclick="toggleProfileDropdown()" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <div class="w-7 h-7 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-xs"></i>
                            </div>
                        </button>
                        
                        <!-- Profile dropdown menu -->
                        <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <a href="#" class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Perfil
                            </a>
                            <a href="#" class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Configurações
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page content -->
        <main class="p-4 sm:p-6 lg:p-8">
            @include('components.alert')
            @yield('content')
        </main>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
        
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const profileButton = event.target.closest('button');
            
            if (!profileButton || !profileButton.onclick || profileButton.onclick.toString().includes('toggleProfileDropdown')) {
                return;
            }
            
            if (!dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 