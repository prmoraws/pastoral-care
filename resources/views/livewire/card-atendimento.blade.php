<div class="bg-white border border-gray-200 rounded-lg mb-4 overflow-hidden">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between px-3 py-2.5">
        <div class="flex items-center gap-2.5">
            <img src="{{ $atendimento->foto ? Storage::url($atendimento->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($atendimento->nome_assistido) . '&size=40&background=efefef&color=333' }}"
                class="w-10 h-10 rounded-full object-cover border border-gray-200" />
            <div>
                <p class="text-sm font-semibold text-gray-900 leading-tight">{{ $atendimento->nome_assistido }}</p>
                <p class="text-xs text-gray-400 leading-tight"> {{ $atendimento->endereco }}</p>
                <p class="text-xs text-gray-400 leading-tight">{{ $atendimento->bairro }}, {{ $atendimento->cidade }}</p>
                <p class="text-xs text-gray-400 leading-tight">📞 {{ $atendimento->contato }} </p>
            </div>
        </div>
        <a href="{{ route('perfil', $atendimento->voluntario->id) }}" class="flex items-center gap-1.5 group">
            <div class="text-right">
                <p class="text-xs font-semibold text-gray-700 group-hover:text-purple-600 leading-tight">
                    {{ $atendimento->voluntario->name }}</p>
                @if ($atendimento->voluntario->condicao)
                    <p class="text-xs text-gray-400 leading-tight">{{ ucfirst($atendimento->voluntario->condicao) }}</p>
                @endif
            </div>
            <img src="{{ $atendimento->voluntario->avatar ? Storage::url($atendimento->voluntario->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($atendimento->voluntario->name) . '&size=32&background=833ab4&color=fff' }}"
                class="w-8 h-8 rounded-full object-cover border-2 border-transparent group-hover:border-purple-400 transition-colors" />
        </a>
    </div>

    {{-- Imagem principal --}}
    @if ($atendimento->imagem)
        <img src="{{ Storage::url($atendimento->imagem) }}" class="w-full object-cover" style="max-height: 400px;" />
    @else
        <div class="w-full flex items-center justify-center py-8"
            style="background: linear-gradient(135deg, #f5f5f5, #efefef);">
            <span class="text-5xl font-bold text-gray-300">{{ mb_substr($atendimento->nome_assistido, 0, 1) }}</span>
        </div>
    @endif

    {{-- Ações --}}
    <div class="px-3 pt-2 pb-1 flex items-center gap-3">
        <button wire:click="curtir" class="focus:outline-none transition-transform active:scale-125">
            @if ($jaCourtiu)
                <svg class="w-6 h-6 text-red-500 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
            @else
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            @endif
        </button>
        <button wire:click="toggleComentarios" class="focus:outline-none">
            <svg class="w-6 h-6 {{ $mostrarComentarios ? 'text-purple-500' : 'text-gray-800' }}" fill="none"
                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
            </svg>
        </button>
        @if ($ehDono)
            <button wire:click="toggleAtualizacao"
                class="focus:outline-none flex items-center gap-1 ml-auto text-gray-500 hover:text-purple-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                </svg>
                <span class="text-xs font-medium">Atualizar</span>
            </button>
        @endif
    </div>

    {{-- Curtidas --}}
    @if ($atendimento->curtidas_count > 0)
        <p class="px-3 text-sm font-semibold text-gray-900">{{ $atendimento->curtidas_count }}
            curtida{{ $atendimento->curtidas_count > 1 ? 's' : '' }}</p>
    @endif

    {{-- Descrição com leia mais --}}
    <div class="px-3 py-2" x-data="{ expandido: false }">
        <p class="text-sm font-semibold text-gray-800 mb-1">{{ $atendimento->titulo }}</p>
        <div x-show="!expandido">
            <p class="text-sm text-gray-800">
                {{ mb_strlen($atendimento->descricao) > 150 ? mb_substr($atendimento->descricao, 0, 150) . '...' : $atendimento->descricao }}
            </p>
            @if (mb_strlen($atendimento->descricao) > 150)
                <button @click="expandido = true" class="text-xs text-gray-400 hover:text-gray-600">leia mais</button>
            @endif
        </div>
        <div x-show="expandido">
            <p class="text-sm text-gray-800">{{ $atendimento->descricao }}</p>
            <button @click="expandido = false" class="text-xs text-gray-400 hover:text-gray-600">menos</button>
        </div>
    </div>

    {{-- Comentários do POST --}}
    @if (!$mostrarComentarios)
        <div class="px-3 py-1 flex items-center gap-2">
            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=28&background=833ab4&color=fff' }}"
                class="w-7 h-7 rounded-full object-cover flex-shrink-0" />
            <button wire:click="toggleComentarios" class="flex-1 text-left text-sm text-gray-400 hover:text-gray-600">
                {{ $atendimento->comentarios_count > 0 ? 'Ver ' . $atendimento->comentarios_count . ' comentário(s)...' : 'Adicione um comentário...' }}
            </button>
        </div>
    @else
        <div class="px-3 py-2 space-y-2">
            @foreach ($comentarios as $comentario)
                <div class="flex gap-2">
                    <img src="{{ $comentario->user->avatar ? Storage::url($comentario->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comentario->user->name) . '&size=28&background=833ab4&color=fff' }}"
                        class="w-7 h-7 rounded-full object-cover flex-shrink-0" />
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

            <div class="flex items-center gap-2 border-t border-gray-50 pt-2">
                <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=28&background=833ab4&color=fff' }}"
                    class="w-7 h-7 rounded-full object-cover flex-shrink-0" />
                <input wire:model="novoComentario" wire:keydown.enter="comentar" type="text"
                    placeholder="Escreva um comentário..."
                    class="flex-1 text-sm focus:outline-none border-b border-gray-200 pb-1 bg-transparent" />
                @if (strlen($novoComentario) > 0)
                    <button wire:click="comentar" class="text-sm font-semibold"
                        style="color: #833ab4;">Publicar</button>
                @endif
            </div>
            <button wire:click="toggleComentarios" class="text-xs text-gray-400 hover:text-gray-600">Ocultar
                comentários</button>
        </div>
    @endif

    {{-- Data --}}
    <p class="px-3 pb-2 text-xs text-gray-400 uppercase tracking-wide">
        {{ $atendimento->data_atendimento->format('d/m/Y') }}</p>

    {{-- Atualizações --}}
    @if ($atualizacoes->count() > 0)
        <div class="border-t border-gray-100">
            @foreach ($atualizacoes as $atualizacao)
                @livewire('card-atualizacao', ['atualizacao' => $atualizacao], key('atualiz-' . $atualizacao->id))
            @endforeach
        </div>
    @endif

    {{-- Formulário nova atualização --}}
    @if ($mostrarAtualizacao && $ehDono)
        <div class="border-t border-gray-100 px-3 py-3 space-y-2 bg-gray-50">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nova Atualização</p>
            <textarea wire:model="descricaoAtualizacao" placeholder="Descreva a atualização..." rows="3"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400 resize-none bg-white"></textarea>
            <div>
                <label class="text-xs text-gray-400 mb-1 block">Foto (opcional)</label>
                <input type="file" wire:model="fotoAtualizacao" accept="image/*" class="text-xs text-gray-500" />
                @if ($fotoAtualizacao)
                    <img src="{{ $fotoAtualizacao->temporaryUrl() }}"
                        class="mt-2 rounded-lg max-h-32 object-cover" />
                @endif
            </div>
            <div class="flex gap-2">
                <button wire:click="registrarAtualizacao"
                    class="px-4 py-1.5 text-sm font-semibold text-white rounded-lg"
                    style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                    Publicar
                </button>
                <button wire:click="toggleAtualizacao" class="px-4 py-1.5 text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </button>
            </div>
        </div>
    @endif

</div>
