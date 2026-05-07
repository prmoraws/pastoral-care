<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastoral Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-bold text-lg text-indigo-600">Pastoral Care</span>
            <div class="flex items-center gap-4">
                @livewire('notificacao-sininho')
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-500 hover:text-red-500">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Conteúdo --}}
    <main class="max-w-2xl mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>