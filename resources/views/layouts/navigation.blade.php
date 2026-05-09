<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-lg mx-auto px-4 py-2 flex items-center justify-between">
        <a href="{{ route('feed') }}" class="font-bold text-xl tracking-tight"
            style="font-family: 'Georgia', serif; background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Pastoral Care
        </a>
        <div class="flex items-center gap-3">
            @livewire('notificacao-sininho')

            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('editor'))
                <a href="{{ url('/admin') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                    Painel
                </a>
            @endif
            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('editor'))
                <a href="{{ route('convites') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                    <span>🔗</span> Gerar Convite
                </a>
            @endif

            <div class="relative" x-data="{ aberto: false }">
                <button @click="aberto = !aberto" class="focus:outline-none">
                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=32&background=833ab4&color=fff' }}"
                        class="w-8 h-8 rounded-full object-cover border border-gray-200" />
                </button>

                <div x-show="aberto" @click.outside="aberto = false" x-transition
                    class="absolute right-0 top-10 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('meu-perfil') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <span>👤</span> Meu Perfil
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <span>🔒</span> Alterar Senha
                    </a>
                    <div class="border-t border-gray-100 mt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50">
                                <span>🚪</span> Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
