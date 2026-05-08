<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    {{-- Cabeçalho do Assistido --}}
    <div class="flex items-center gap-3 p-4 border-b border-gray-100">
        <img
            src="{{ $atendimento->foto ? Storage::url($atendimento->foto) : 'https://ui-avatars.com/api/?name='.urlencode($atendimento->nome_assistido) }}"
            class="w-12 h-12 rounded-full object-cover"
            alt="{{ $atendimento->nome_assistido }}"
        />
        <div class="flex-1">
            <p class="font-semibold text-gray-800">{{ $atendimento->nome_assistido }}</p>
            <p class="text-xs text-gray-400">
                {{ $atendimento->endereco }}, {{ $atendimento->bairro }} — {{ $atendimento->cidade }}
            </p>
            <p class="text-xs text-gray-400">📞 {{ $atendimento->contato }}</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-400">{{ $atendimento->titulo }}</p>
            <p class="text-xs text-gray-300">por {{ $atendimento->voluntario->name }}</p>
            @if($atendimento->voluntario->cargo)
                <p class="text-xs text-indigo-400">{{ $atendimento->voluntario->cargo }}</p>
            @endif
        </div>
    </div>

    {{-- Descrição --}}
    <div class="p-4">
        <p class="text-gray-700 text-sm">{{ $atendimento->descricao }}</p>
    </div>

    {{-- Imagem do atendimento --}}
    @if($atendimento->imagem)
        <img
            src="{{ Storage::url($atendimento->imagem) }}"
            class="w-full object-cover max-h-72"
            alt="Imagem do atendimento"
        />
    @endif

    {{-- Ações --}}
    <div class="flex items-center gap-4 px-4 py-3 text-sm text-gray-500 border-t border-gray-100">
        <button wire:click="curtir" class="flex items-center gap-1 hover:text-red-500 transition-colors {{ $jaCourtiu ? 'text-red-500' : '' }}">
            {{ $jaCourtiu ? '❤️' : '🤍' }} <span>{{ $atendimento->curtidas_count }}</span>
        </button>

        <button wire:click="toggleComentarios" class="flex items-center gap-1 hover:text-indigo-500 transition-colors">
            💬 <span>{{ $atendimento->comentarios_count }}</span>
        </button>

        <span class="ml-auto text-xs text-gray-300">
            {{ $atendimento->data_atendimento->format('d/m/Y') }}
        </span>
    </div>

    {{-- Comentários --}}
    @if($mostrarComentarios)
        <div class="px-4 pb-4 space-y-2 border-t border-gray-50 pt-3">
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