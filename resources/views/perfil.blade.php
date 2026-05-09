<x-app-layout>
    <div class="max-w-lg mx-auto px-4 py-6">
        @php
            $perfil = $user->hasRole('author')
                ? $user->perfilVoluntario
                : ($user->hasRole('editor')
                    ? $user->perfilCoordenador
                    : null);
            $avatar = $perfil?->avatar
                ? Storage::url($perfil->avatar)
                : 'https://ui-avatars.com/api/?name=' .
                    urlencode($user->name) .
                    '&size=200&background=833ab4&color=fff';
        @endphp

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

            {{-- Banner gradiente --}}
            <div class="h-28 w-full relative"
                style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);">
                <div class="absolute inset-0 opacity-20"
                    style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px),
                radial-gradient(circle at 80% 20%, white 1px, transparent 1px);
                background-size: 30px 30px;">
                </div>
            </div>

            <div class="px-5 pb-6">
                {{-- Avatar centralizado --}}
                <div class="flex flex-col items-center -mt-14 mb-4">
                    <div class="relative">
                        <img src="{{ $avatar }}"
                            class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg" />
                        <div
                            class="absolute bottom-1 right-1 w-4 h-4 rounded-full border-2 border-white {{ $perfil?->ativo ?? true ? 'bg-green-400' : 'bg-gray-300' }}">
                        </div>
                    </div>

                    <h1 class="text-xl font-bold text-gray-900 mt-3">{{ $user->name }}</h1>

                    @if ($perfil?->cargo)
                        <span class="text-sm font-medium text-white px-3 py-1 rounded-full mt-1"
                            style="background: linear-gradient(45deg, #833ab4, #fd1d1d);">
                            {{ $perfil->cargo }}
                        </span>
                    @endif

                    @if ($perfil?->condicao)
                        <span class="text-sm font-medium text-white px-3 py-1 rounded-full mt-1"
                            style="background: linear-gradient(45deg, #833ab4, #fcb045);">
                            {{ $perfil->condicao }}
                        </span>
                    @endif

                    @if ($perfil?->igreja)
                        <p class="text-sm text-gray-500 mt-1">{{ $perfil->igreja }}</p>
                    @endif

                    @if (auth()->id() === $user->id)
                        <a href="{{ route('meu-perfil') }}"
                            class="mt-3 px-5 py-2 text-sm font-semibold text-white rounded-full"
                            style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                            ✏️ Editar Perfil
                        </a>
                    @endif
                </div>

                {{-- Estatísticas --}}
                <div class="flex justify-center gap-8 py-4 border-t border-b border-gray-100 mb-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $user->assistidos()->count() }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Atendimentos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\Curtida::whereIn('atendimento_id', $user->assistidos()->pluck('id'))->count() }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">Curtidas</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\Comentario::whereIn('atendimento_id', $user->assistidos()->pluck('id'))->count() }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">Comentários</p>
                    </div>
                </div>

                {{-- Informações de contato --}}
                <div class="space-y-3">
                    @if ($user->email)
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background: #f8f4ff;">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: linear-gradient(45deg, #833ab4, #fd1d1d);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">E-mail</p>
                                <p class="text-sm font-medium text-gray-700">{{ $user->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($perfil?->contato)
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background: #f8f4ff;">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: linear-gradient(45deg, #833ab4, #fcb045);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Contato</p>
                                <p class="text-sm font-medium text-gray-700">{{ $perfil->contato }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($perfil?->igreja)
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background: #f8f4ff;">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: linear-gradient(45deg, #fd1d1d, #fcb045);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Igreja / Região / Bloco</p>
                                <p class="text-sm font-medium text-gray-700">{{ $perfil->igreja }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
