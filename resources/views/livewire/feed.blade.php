<div>
    <div class="bg-white border border-gray-200 rounded-lg p-3 mb-4 space-y-2">
        <div class="flex items-center gap-2">
            <input wire:model.live.debounce.300ms="busca" type="text" placeholder="Buscar assistido..."
                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            @livewire('novo-atendimento')
        </div>

        @if (auth()->user()->hasRole('editor') || auth()->user()->hasRole('super_admin'))
            <div class="flex gap-2">
                <select wire:model.live="filtroVoluntario"
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
                    <option value="">Todos os voluntários</option>
                    @foreach ($voluntarios as $id => $nome)
                        <option value="{{ $id }}">{{ $nome }}</option>
                    @endforeach
                </select>
                <input wire:model.live="filtroData" type="date"
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none" />
            </div>
        @endif
    </div>

    @forelse($assistidos as $assistido)
        @livewire('card-atendimento', ['atendimento' => $assistido], key($assistido->id))
    @empty
        <div class="text-center text-gray-400 py-16">
            <p class="text-lg">Nenhum assistido encontrado.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $assistidos->links() }}
    </div>
</div>
