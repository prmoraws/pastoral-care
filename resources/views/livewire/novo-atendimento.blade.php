<div>
    {{-- Botão abrir --}}
    <button wire:click="$set('aberto', true)"
        class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white rounded-lg whitespace-nowrap"
        style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Novo
    </button>

    {{-- Modal --}}
    @if ($aberto)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center px-0 sm:px-4"
            style="background: rgba(0,0,0,0.5);">
            <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-lg"
                style="max-height: 90vh; overflow-y: auto;">
                {{-- Header --}}
                <div
                    class="flex items-center justify-between px-5 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                    <h2 class="font-bold text-gray-800">Novo Atendimento</h2>
                    <button wire:click="$set('aberto', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Campos --}}
                <div class="px-5 py-4 space-y-4">

                    {{-- Foto do assistido --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Foto do
                            Assistido</label>
                        <input type="file" wire:model="foto" accept="image/*"
                            class="mt-1 text-sm text-gray-500 w-full" />
                        @if ($foto)
                            <img src="{{ $foto->temporaryUrl() }}" class="mt-2 w-16 h-16 rounded-full object-cover" />
                        @endif
                        @error('foto')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nome --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nome do Assistido
                            *</label>
                        <input wire:model="nome_assistido" type="text"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                        @error('nome_assistido')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contato --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Contato *</label>
                        <input wire:model="contato" type="tel"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                        @error('contato')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Endereço --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Endereço *</label>
                        <input wire:model="endereco" type="text"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                        @error('endereco')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bairro + Cidade --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Bairro *</label>
                            <input wire:model="bairro" type="text"
                                class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                            @error('bairro')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cidade *</label>
                            <input wire:model="cidade" type="text"
                                class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                            @error('cidade')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Data --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Data do Atendimento
                            *</label>
                        <input wire:model="data_atendimento" type="date"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                        @error('data_atendimento')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Descrição do
                            Atendimento *</label>
                        <textarea wire:model="descricao" rows="4"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400 resize-none"></textarea>
                        @error('descricao')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagem do atendimento --}}
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Imagem do
                            Atendimento</label>
                        <input type="file" wire:model="imagem" accept="image/*"
                            class="mt-1 text-sm text-gray-500 w-full" />
                        @if ($imagem)
                            <img src="{{ $imagem->temporaryUrl() }}"
                                class="mt-2 rounded-lg max-h-40 object-cover w-full" />
                        @endif
                        @error('imagem')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Footer fixo --}}
                <div class="px-5 py-4 border-t border-gray-100 flex gap-3 sticky bottom-0 bg-white">
                    <button wire:click="salvar" wire:loading.attr="disabled"
                        class="flex-1 py-3 text-sm font-semibold text-white rounded-xl"
                        style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                        <span wire:loading.remove>Publicar Atendimento</span>
                        <span wire:loading>Salvando...</span>
                    </button>
                    <button wire:click="$set('aberto', false)"
                        class="px-4 py-3 text-sm text-gray-500 hover:text-gray-700 border border-gray-200 rounded-xl">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
