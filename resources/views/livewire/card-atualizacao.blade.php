<div class="border-t border-gray-100 px-3 py-3">
    {{-- Cabeçalho --}}
    <div class="flex items-center gap-2 mb-2">
        <img src="{{ $atualizacao->voluntario->avatar ? Storage::url($atualizacao->voluntario->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($atualizacao->voluntario->name) . '&size=28&background=833ab4&color=fff' }}"
            class="w-6 h-6 rounded-full object-cover" />
        <span class="text-xs font-semibold" style="color: #833ab4;">Atualização</span>
        <span class="text-xs text-gray-400">· {{ $atualizacao->created_at->format('d/m/Y') }}</span>
    </div>

    {{-- Descrição com "leia mais" --}}
    <div x-data="{ expandido: false }">
        <p class="text-sm text-gray-800" x-show="expandido">{{ $atualizacao->descricao }}</p>
        <p class="text-sm text-gray-800" x-show="!expandido">
            {{ mb_strlen($atualizacao->descricao) > 120 ? mb_substr($atualizacao->descricao, 0, 120) . '...' : $atualizacao->descricao }}
        </p>
        @if (mb_strlen($atualizacao->descricao) > 120)
            <button @click="expandido = !expandido" class="text-xs text-gray-400 hover:text-gray-600 mt-0.5">
                <span x-show="!expandido">leia mais</span>
                <span x-show="expandido">menos</span>
            </button>
        @endif
    </div>

    {{-- Foto --}}
    @if ($atualizacao->foto)
        <img src="{{ Storage::url($atualizacao->foto) }}" class="w-full rounded-lg mt-2 object-cover max-h-64" />
    @endif

    {{-- Ações --}}
    <div class="flex items-center gap-3 mt-2">
        <button wire:click="curtir" class="focus:outline-none transition-transform active:scale-125">
            @if ($jaCourtiu)
                <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
            @else
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            @endif
        </button>
        @if ($atualizacao->curtidas_count > 0)
            <span class="text-xs text-gray-500">{{ $atualizacao->curtidas_count }}</span>
        @endif

        <button wire:click="toggleComentarios" class="focus:outline-none flex items-center gap-1">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
            </svg>
            @if ($atualizacao->comentarios_count > 0)
                <span class="text-xs text-gray-500">{{ $atualizacao->comentarios_count }}</span>
            @endif
        </button>
    </div>

    {{-- Comentários --}}
    @if ($mostrarComentarios)
        <div class="mt-2 space-y-2 border-t border-gray-100 pt-2">
            @foreach ($comentarios as $comentario)
                <div class="flex gap-2">
                    <img src="{{ $comentario->user?->avatar ? Storage::url($comentario->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comentario->user?->name ?? 'Removido') . '&size=24&background=833ab4&color=fff' }}"
                        class="w-6 h-6 rounded-full object-cover flex-shrink-0" />
                    <div class="flex-1">
                        @if ($editandoComentarioId === $comentario->id)
                            <div class="flex items-center gap-2">
                                <input wire:model="textoEdicao" wire:keydown.enter="salvarEdicao" type="text"
                                    class="flex-1 text-sm border-b border-purple-300 focus:outline-none pb-1 bg-transparent" />
                                <button wire:click="salvarEdicao" class="text-xs font-semibold"
                                    style="color: #833ab4;">Salvar</button>
                                <button wire:click="cancelarEdicao" class="text-xs text-gray-400">Cancelar</button>
                            </div>
                        @else
                            <p class="text-sm text-gray-800">
                                <span class="font-semibold">{{ $comentario->autor_label }}</span>
                                {{ $comentario->comentario }}
                            </p>
                            @if ($comentario->user_id === Auth::id())
                                <button
                                    wire:click="iniciarEdicao({{ $comentario->id }}, '{{ addslashes($comentario->comentario) }}')"
                                    class="text-xs text-gray-400 hover:text-purple-500 mt-0.5">
                                    Editar
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="flex items-center gap-2 pt-1">
                <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=24&background=833ab4&color=fff' }}"
                    class="w-6 h-6 rounded-full object-cover flex-shrink-0" />
                <input wire:model="novoComentario" wire:keydown.enter="comentar" type="text"
                    placeholder="Comentar na atualização..."
                    class="flex-1 text-sm focus:outline-none border-b border-gray-200 pb-1 bg-transparent" />
                @if (strlen($novoComentario) > 0)
                    <button wire:click="comentar" class="text-xs font-semibold"
                        style="color: #833ab4;">Publicar</button>
                @endif
            </div>

            <button wire:click="toggleComentarios" class="text-xs text-gray-400 hover:text-gray-600">Fechar</button>
        </div>
    @endif
</div>
