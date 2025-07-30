@extends('layouts.app')

@section('title', 'MotoRentPro - Sistema de Gestão')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-4">
    <div class="w-full max-w-md text-center">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">MotoRentPro</h1>
            <p class="text-lg text-gray-600 font-medium mb-8">Sistema de Gestão de Aluguel de Motos</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 p-10 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bem-vindo ao Sistema</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Acesse o sistema para gerenciar seus aluguéis de motos de forma profissional e eficiente.
            </p>
            
            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Acessar Sistema
            </a>
        </div>
        
        <div class="text-center space-y-2">
            <p class="text-sm text-gray-500">
                &copy; 2025 MotoRentPro. Todos os direitos reservados.
            </p>
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
