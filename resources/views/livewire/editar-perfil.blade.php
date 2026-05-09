<div class="max-w-lg mx-auto py-4 space-y-4">

    {{-- Mensagens --}}
    @if ($mensagem)
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            ✅ {{ $mensagem }}
        </div>
    @endif
    @if ($erro)
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            ❌ {{ $erro }}
        </div>
    @endif

    {{-- Seção: Dados Pessoais --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="h-16 w-full" style="background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);"></div>
        <div class="px-4 pb-4">
            <div class="flex items-end gap-4 -mt-8 mb-4">
                <div class="relative">
                    <img src="{{ $avatarAtual ? Storage::url($avatarAtual) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80&background=833ab4&color=fff' }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" />
                </div>
                <div class="pb-1">
                    <p class="font-bold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Foto de Perfil</label>
                    <input type="file" wire:model="avatar" accept="image/*"
                        class="mt-1 text-sm text-gray-500 w-full" />
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="mt-2 w-16 h-16 rounded-full object-cover" />
                    @endif
                    @error('avatar')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nome Completo</label>
                    <input wire:model="name" type="text"
                        class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">E-mail</label>
                    <input wire:model="email" type="email"
                        class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
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

                @if (auth()->user()->hasRole('author'))
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Condição</label>
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
                    </div>
                @endif

                @if (auth()->user()->hasRole('editor'))
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo</label>
                        <select wire:model="cargo"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400">
                            <option value="">Selecione...</option>
                            <option value="Bispo">Bispo</option>
                            <option value="Pastor">Pastor</option>
                            <option value="Esposa">Esposa</option>
                            <option value="Obreiro">Obreiro</option>
                        </select>
                    </div>
                @endif

                <button wire:click="salvarPerfil" wire:loading.attr="disabled"
                    class="w-full py-3 text-sm font-semibold text-white rounded-xl mt-2"
                    style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                    <span wire:loading.remove>Salvar Perfil</span>
                    <span wire:loading>Salvando...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Seção: Alterar Senha --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 space-y-3">
        <h2 class="font-bold text-gray-800">🔒 Alterar Senha</h2>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Senha Atual</label>
            <input wire:model="senhaAtual" type="password"
                class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            @error('senhaAtual')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nova Senha</label>
            <input wire:model="novaSenha" type="password"
                class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
            @error('novaSenha')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Confirmar Nova Senha</label>
            <input wire:model="novaSenhaConfirmacao" type="password"
                class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-purple-400" />
        </div>

        <button wire:click="alterarSenha" wire:loading.attr="disabled"
            class="w-full py-3 text-sm font-semibold text-white rounded-xl"
            style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
            <span wire:loading.remove>Alterar Senha</span>
            <span wire:loading>Alterando...</span>
        </button>
    </div>

</div>
