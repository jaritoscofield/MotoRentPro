@extends('layouts.auth')

@section('title', 'Login - MotoRentPro')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 p-4">
    <div class="w-full max-w-md space-y-8">
        @include('components.logo')
        @include('components.login-form')
        
        <!-- Footer -->
        <div class="text-center space-y-2">
            <p class="text-xs text-gray-400 dark:text-gray-500">
                Desenvolvido com ❤️ pela 
                <a href="https://www.instagram.com/belem_sistemas/" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 font-medium transition-colors duration-200">
                    Belém Sistemas
                </a>
            </p>
        </div>
    </div>
</div>
@endsection 