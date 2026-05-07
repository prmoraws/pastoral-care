<div class="border-t border-gray-100 p-4">
    {{-- Título --}}
    <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wide mb-2">
        {{ $atendimento->titulo }}
    </p>

    {{-- Descrição --}}
    <p class="text-gray-700 text-sm mb-3">{{ $atendimento->descricao }}</p>

    {{-- Imagem --}}
    @if($atendimento->imagem)
        <img
            src="{{ Storage::url($atendimento->imagem) }}"
            class="w-full rounded-lg mb-3 object-cover max-h-64"
            alt="Imagem do atendimento"
        />
    @endif

    {{-- Ações --}}
    <div class="flex items-center gap-4 text-sm text-gray-500">
        {{-- Curtir --}}
        <button wire:click="curtir" class="flex items-center gap-1 hover:text-red-500 transition-colors {{ $jaCourtiu ? 'text-red-500' : '' }}">
            {{ $jaCourtiu ? '❤️' : '🤍' }}
            <span>{{ $atendimento->curtidas_count }}</span>
        </button>

        {{-- Comentários --}}
        <button wire:click="toggleComentarios" class="flex items-center gap-1 hover:text-indigo-500 transition-colors">
            💬 <span>{{ $atendimento->comentarios_count }}</span>
        </button>

        <span class="ml-auto text-xs text-gray-300">
            {{ $atendimento->data_atendimento->format('d/m/Y') }}
        </span>
    </div>

    {{-- Seção de comentários --}}
    @if($mostrarComentarios)
        <div class="mt-3 space-y-2">
            @foreach($comentarios as $comentario)
                <div class="flex gap-2">
                    <img
                        src="{{ $comentario->user->avatar ? Storage::url($comentario->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($comentario->user->name).'&size=32' }}"
                        class="w-7 h-7 rounded-full object-cover flex-shrink-0"
                    />
                    <div class="bg-gray-50 rounded-lg px-3 py-2 flex-1">
                        <p class="text-xs font-semibold text-gray-700">{{ $comentario->autor_label }}</p>
                        <p class="text-sm text-gray-600">{{ $comentario->comentario }}</p>
                    </div>
                </div>
            @endforeach

            {{-- Campo novo comentário --}}
            <div class="flex gap-2 mt-2">
                <input
                    wire:model="novoComentario"
                    wire:keydown.enter="comentar"
                    type="text"
                    placeholder="Escreva um comentário..."
                    class="flex-1 border border-gray-200 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                />
                <button
                    wire:click="comentar"
                    class="bg-indigo-500 text-white rounded-full px-4 py-2 text-sm hover:bg-indigo-600 transition-colors"
                >
                    Enviar
                </button>
            </div>
        </div>
    @endif
</div>