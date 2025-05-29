@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            REMOÇÃO DOS DADOS PESSOAIS
        </h1>
    </div>

    @include('components.error')

    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow p-6 md:p-10 space-y-6">
        <form action="{{ route('delete-data') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nome Completo
                </label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ex. Wilma Sousa" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Seu Telefone
                </label>
                <div class="flex space-x-2">
                    <select name="country_code" class="w-28 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" required>
                        <option value="+244">AO</option>
                        <option value="+351">PT</option>
                        <option value="+55">BR</option>
                        <option value="+212">MA</option>
                    </select>
                    <input type="text" name="phone" class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+244 943 000 000" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Seu Motivo (Opcional)
                </label>
                <textarea name="feedback" rows="5" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="O que o motiva a deixar o nosso aplicativo?"></textarea>
            </div>

            <div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-red-500">
                    <i class="fas fa-trash-alt mr-2"></i> Solicitar remoção de dados pessoais
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
