<div class="bg-white rounded-xl shadow-2xl border-2 border-gray-300 py-10 px-8 max-w-md w-full">
    <!-- Título e Subtítulo -->
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">MotoRentPro</h2>
        <p class="text-gray-700 text-sm font-medium">Sistema de Gestão de Aluguel de Motos</p>
    </div>

    <form class="space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        
        <!-- Campo Email -->
        <div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    value="{{ old('email') }}"
                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none bg-gray-50"
                    placeholder="E-mail"
                    autocomplete="email"
                >
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-500 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Campo Senha -->
        <div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required
                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none bg-gray-50"
                    placeholder="Senha"
                    autocomplete="current-password"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-500 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Botão de Login -->
        <div class="pt-2">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Entrar
            </button>
        </div>
    </form>
</div> 