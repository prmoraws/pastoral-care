<div class="min-h-screen flex items-end sm:items-center justify-center"
    style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);">
    <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md"
        style="max-height: 95vh; overflow-y: auto;">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 text-center">
            <h1 class="text-2xl font-bold"
                style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Pastoral Care
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Você foi convidado como
                <span class="font-semibold" style="color: #833ab4;">
                    {{ $convite->papel === 'editor' ? 'Coordenador' : 'Voluntário' }}
                </span>
            </p>
        </div>

        <div class="px-6 py-5 space-y-4" style="max-height: 80vh; overflow-y: auto;">

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nome Completo *</label>
                <input wire:model="name" type="text"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">E-mail *</label>
                <input wire:model="email" type="email"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Senha *</label>
                <input wire:model="password" type="password"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Confirmar Senha *</label>
                <input wire:model="password_confirmation" type="password"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Contato</label>
                <input wire:model="contato" type="tel"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Igreja / Região /
                    Bloco</label>
                <input wire:model="igreja" type="text"
                    class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            </div>

            @if ($convite->papel === 'author')
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Condição *</label>
                    <select wire:model="condicao"
                        class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400">
                        <option value="">Selecione...</option>
                        <option value="Bispo">Bispo</option>
                        <option value="Pastor">Pastor</option>
                        <option value="Esposa">Esposa</option>
                        <option value="Obreiro">Obreiro</option>
                        <option value="Evangelista">Evangelista</option>
                        <option value="Lider de Grupo">Líder de Grupo</option>
                        <option value="Membro">Membro</option>
                    </select>
                    @error('condicao')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($convite->papel === 'editor')
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo *</label>
                    <select wire:model="cargo"
                        class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400">
                        <option value="">Selecione...</option>
                        <option value="Bispo">Bispo</option>
                        <option value="Pastor">Pastor</option>
                        <option value="Esposa">Esposa</option>
                        <option value="Obreiro">Obreiro</option>
                    </select>
                    @error('cargo')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <button wire:click="registrar" wire:loading.attr="disabled"
                class="w-full py-3 text-sm font-semibold text-white rounded-xl"
                style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                <span wire:loading.remove>Criar Minha Conta</span>
                <span wire:loading>Criando conta...</span>
            </button>
        </div>
    </div>
</div>
