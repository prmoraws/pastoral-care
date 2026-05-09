<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite Inválido — Pastoral Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex items-center justify-center px-4"
        style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-8 text-center">
            <div class="text-5xl mb-4">🔗</div>
            <h1 class="text-xl font-bold text-gray-800 mb-2">Convite Inválido</h1>
            <p class="text-sm text-gray-500 mb-6">
                Este link de convite já foi utilizado ou expirou.<br>
                Entre em contato com seu coordenador para receber um novo convite.
            </p>
            <a href="{{ url('/login') }}" class="inline-block px-6 py-2.5 text-sm font-semibold text-white rounded-xl"
                style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                Ir para Login
            </a>
        </div>
    </div>
</body>

</html>
