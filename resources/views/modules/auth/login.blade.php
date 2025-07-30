@extends('layouts.app')

@section('title', 'Login - MotoRentPro')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-4">
    <div class="w-full max-w-md space-y-8">
        @include('components.logo')
        @include('components.login-form')
        
        <!-- Footer -->
        <div class="text-center space-y-2">
            <p class="text-xs text-gray-400">
                Desenvolvido com ❤️ pela 
                <a href="https://www.instagram.com/belem_sistemas/" target="_blank" class="text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                    Belém Sistemas
                </a>
            </p>
        </div>
    </div>
</div>
@endsection 