<div class="max-w-lg mx-auto py-4 px-4 space-y-4">

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="h-16 w-full" style="background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);"></div>
        <div class="px-5 py-4">
            <h2 class="font-bold text-gray-800 text-lg mb-4">🔗 Gerar Link de Convite</h2>

            @if (!$linkGerado)
                <div class="space-y-4">
                    {{-- Papel (apenas super_admin vê as duas opções) --}}
                    @if (auth()->user()->hasRole('super_admin'))
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de
                                Convite</label>
                            <div class="flex gap-3 mt-2">
                                <button wire:click="$set('papel', 'editor')"
                                    class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-all {{ $papel === 'editor' ? 'border-purple-500 text-purple-600 bg-purple-50' : 'border-gray-200 text-gray-500' }}">
                                    👑 Coordenador
                                </button>
                                <button wire:click="$set('papel', 'author')"
                                    class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-all {{ $papel === 'author' ? 'border-purple-500 text-purple-600 bg-purple-50' : 'border-gray-200 text-gray-500' }}">
                                    🙋 Voluntário
                                </button>
                            </div>
                            @error('papel')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div class="bg-purple-50 rounded-xl px-4 py-3">
                            <p class="text-sm text-purple-700 font-medium">🙋 Convite para Voluntário</p>
                            <p class="text-xs text-purple-400 mt-0.5">Coordenadores só podem convidar voluntários.</p>
                        </div>
                    @endif

                    <button wire:click="gerar" wire:loading.attr="disabled"
                        class="w-full py-3 text-sm font-semibold text-white rounded-xl"
                        style="background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);">
                        <span wire:loading.remove>Gerar Link de Convite</span>
                        <span wire:loading>Gerando...</span>
                    </button>
                </div>
            @else
                {{-- Link gerado --}}
                <div class="space-y-3">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <p class="text-xs font-semibold text-green-600 mb-2">✅ Link gerado! Válido por 7 dias ou até 1
                            uso.</p>
                        <div class="bg-white rounded-lg px-3 py-2 border border-green-200 break-all">
                            <p class="text-xs text-gray-600 font-mono">{{ $linkGerado }}</p>
                        </div>
                    </div>

                    <button
                        onclick="navigator.clipboard.writeText('{{ $linkGerado }}').then(() => { this.textContent = '✅ Copiado!'; setTimeout(() => this.textContent = '📋 Copiar Link', 2000); })"
                        class="w-full py-3 text-sm font-semibold border-2 border-purple-400 text-purple-600 rounded-xl hover:bg-purple-50 transition">
                        📋 Copiar Link
                    </button>

                    <button wire:click="novoLink"
                        class="w-full py-2.5 text-sm text-gray-500 hover:text-gray-700 border border-gray-200 rounded-xl">
                        Gerar Novo Link
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Histórico de convites --}}
    @if ($convites->count() > 0)
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <h3 class="font-semibold text-gray-700 text-sm mb-3">Convites Recentes</h3>
            <div class="space-y-2">
                @foreach ($convites as $convite)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-xs font-medium text-gray-700">
                                {{ $convite->papel === 'editor' ? '👑 Coordenador' : '🙋 Voluntário' }}
                            </p>
                            <p class="text-xs text-gray-400">Expira: {{ $convite->expires_at->format('d/m/Y') }}</p>
                        </div>
                        <span
                            class="text-xs px-2 py-1 rounded-full font-semibold
                            {{ $convite->usado ? 'bg-gray-100 text-gray-400' : ($convite->expires_at->isFuture() ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-400') }}">
                            {{ $convite->usado ? 'Usado' : ($convite->expires_at->isFuture() ? 'Ativo' : 'Expirado') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
