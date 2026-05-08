<div>
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 space-y-3">
        <input
            wire:model.live.debounce.300ms="busca"
            type="text"
            placeholder="Buscar assistido..."
            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
        />

        @if(auth()->user()->hasRole('editor') || auth()->user()->hasRole('super_admin'))
        <div class="flex gap-2">
            <select wire:model.live="filtroVoluntario" class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Todos os voluntários</option>
                @foreach($voluntarios as $id => $nome)
                    <option value="{{ $id }}">{{ $nome }}</option>
                @endforeach
            </select>

            <input
                wire:model.live="filtroData"
                type="date"
                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm"
            />
        </div>
        @endif
    </div>

    @forelse($atendimentos as $atendimento)
        @livewire('card-atendimento', ['atendimento' => $atendimento], key($atendimento->id))
    @empty
        <div class="text-center text-gray-400 py-16">
            <p class="text-lg">Nenhum atendimento encontrado.</p>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $atendimentos->links() }}
    </div>
</div>