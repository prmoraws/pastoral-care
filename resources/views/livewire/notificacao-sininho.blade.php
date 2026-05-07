<div class="relative">
    <button wire:click="toggleAberto" class="relative p-1 text-gray-500 hover:text-indigo-600 transition-colors">
        🔔
        @if($naoLidas > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                {{ $naoLidas }}
            </span>
        @endif
    </button>

    @if($aberto)
        <div class="absolute right-0 top-8 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="font-semibold text-sm text-gray-700">Notificações</span>
                @if($naoLidas > 0)
                    <button wire:click="marcarTodasLidas" class="text-xs text-indigo-500 hover:text-indigo-700">
                        Marcar todas como lidas
                    </button>
                @endif
            </div>

            <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                @forelse($notificacoes as $notificacao)
                    @php $data = $notificacao->data @endphp
                    <div class="px-4 py-3 {{ $notificacao->read_at ? 'opacity-50' : 'bg-indigo-50' }}">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">{{ $data['autor'] }}</span>
                            comentou no atendimento de
                            <span class="font-semibold">{{ $data['pessoa'] }}</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1 truncate">{{ $data['comentario'] }}</p>
                        <p class="text-xs text-gray-300 mt-1">{{ $notificacao->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-4 py-6 text-center text-gray-400 text-sm">
                        Nenhuma notificação.
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>