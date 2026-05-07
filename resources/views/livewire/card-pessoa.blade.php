<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    <div class="flex items-center gap-3 p-4 border-b border-gray-100">
        <img
            src="{{ $pessoa->foto ? Storage::url($pessoa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pessoa->nome) }}"
            class="w-12 h-12 rounded-full object-cover"
            alt="{{ $pessoa->nome }}"
        />
        <div class="flex-1">
            <p class="font-semibold text-gray-800">{{ $pessoa->nome }}</p>
            <p class="text-xs text-gray-400">
                Voluntário: {{ $pessoa->voluntario->name }}
                @if($pessoa->voluntario->condicao)
                    · {{ ucfirst($pessoa->voluntario->condicao) }}
                @endif
            </p>
        </div>
        <span class="text-xs text-gray-400">{{ $pessoa->atendimentos_count }} atendimento(s)</span>
    </div>

    @foreach($pessoa->atendimentos as $atendimento)
        @livewire('card-atendimento', ['atendimento' => $atendimento], key($atendimento->id))
    @endforeach

    @if(auth()->id() === $pessoa->user_id)
        <div class="p-4 border-t border-gray-100">
            
                href="{{ route('filament.admin.resources.atendimentos.create') }}"
                class="text-sm text-indigo-500 hover:text-indigo-700 font-medium"
            >
                + Adicionar atendimento
            </a>
        </div>
    @endif
</div>