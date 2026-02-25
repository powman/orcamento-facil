<div>
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('budgets.index') }}" class="text-slate-500 hover:text-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-800">
            {{ $budget && $budget->exists ? 'Editar Orçamento ' . $budget->budget_number : 'Novo Orçamento' }}
        </h2>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Client Section -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Dados do Cliente</h3>

                <!-- Client Search -->
                <div class="mb-4 relative">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Buscar cliente cadastrado</label>
                    <input type="text" wire:model.live="clientSearch"
                           placeholder="Digite o nome ou CPF/CNPJ..."
                           class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                    @if($showClientSuggestions && count($clientSuggestions) > 0)
                        <div class="absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 overflow-hidden">
                            @foreach($clientSuggestions as $suggestion)
                                <button type="button" wire:click="selectClient({{ $suggestion['id'] }})"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 transition-colors border-b border-slate-100 last:border-0">
                                    <div class="text-sm font-medium text-slate-800">{{ $suggestion['name'] }}</div>
                                    @if($suggestion['cpf_cnpj'])
                                        <div class="text-xs text-slate-500">{{ $suggestion['cpf_cnpj'] }}</div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome do Cliente</label>
                        <input type="text" wire:model="client_name"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('client_name') border-red-500 @enderror">
                        @error('client_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">CPF / CNPJ</label>
                        <input type="text" wire:model="client_cpf_cnpj"
                               x-on:input="$event.target.value = maskCpfCnpj($event.target.value)"
                               placeholder="000.000.000-00"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Endereço</label>
                        <input type="text" wire:model="client_address"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Itens do Orçamento</h3>

                @error('items')
                    <div class="mb-3 text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-slate-500 uppercase bg-slate-50">
                                <th class="px-3 py-2 rounded-tl-lg">Descrição</th>
                                <th class="px-3 py-2 w-28 text-center">Qtd</th>
                                <th class="px-3 py-2 w-32 text-right">Preço Unit.</th>
                                <th class="px-3 py-2 w-32 text-right">Subtotal</th>
                                <th class="px-3 py-2 w-20 rounded-tr-lg"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                <tr class="border-b border-slate-100 last:border-0">
                                    <td class="px-3 py-2">
                                        <input type="text" wire:model="items.{{ $index }}.description"
                                               placeholder="Descrição do serviço/produto"
                                               class="w-full border border-slate-200 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('items.'.$index.'.description') border-red-500 @enderror">
                                        @error('items.'.$index.'.description')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" wire:model.blur="items.{{ $index }}.quantity"
                                               class="w-full border border-slate-200 rounded px-2 py-1.5 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" wire:model.blur="items.{{ $index }}.unit_price"
                                               class="w-full border border-slate-200 rounded px-2 py-1.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="px-3 py-2 text-right font-medium text-slate-700">
                                        @php
                                            $qty = (float) str_replace(['.', ','], ['', '.'], $item['quantity'] ?? '0');
                                            $price = (float) str_replace(['.', ','], ['', '.'], $item['unit_price'] ?? '0');
                                        @endphp
                                        R$ {{ number_format($qty * $price, 2, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center gap-1">
                                            <button type="button" wire:click="duplicateItem({{ $index }})"
                                                    title="Duplicar" class="p-1 text-slate-400 hover:text-blue-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                            @if(count($items) > 1)
                                                <button type="button" wire:click="removeItem({{ $index }})"
                                                        title="Remover" class="p-1 text-slate-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center gap-3 flex-wrap">
                    <button type="button" wire:click="addItem"
                            class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Adicionar Item
                    </button>

                    @if($companyCatalog->isNotEmpty())
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">ou selecionar do catálogo:</span>
                            <select x-data onchange="if(this.value) { $wire.addItemFromCatalog(this.value); this.value = ''; }"
                                    class="border border-slate-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— Catálogo —</option>
                                @foreach($companyCatalog as $catalogItem)
                                    <option value="{{ $catalogItem->id }}">
                                        {{ $catalogItem->name }}
                                        @if($catalogItem->unit_price)
                                            — R$ {{ number_format((float)$catalogItem->unit_price, 2, ',', '.') }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Observações</h3>
                <textarea wire:model="notes" rows="3"
                          placeholder="Condições de pagamento, prazo de entrega, garantias..."
                          class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Totals -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Totais</h3>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-medium">R$ {{ number_format($this->subtotal, 2, ',', '.') }}</span>
                    </div>

                    <!-- Discount/Surcharge -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex gap-2 mb-2">
                            <select wire:model.live="discount_sign"
                                    class="flex-1 border border-slate-300 rounded px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="discount">Desconto</option>
                                <option value="surcharge">Acréscimo</option>
                            </select>
                            <select wire:model.live="discount_type"
                                    class="flex-1 border border-slate-300 rounded px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="money">R$</option>
                                <option value="percent">%</option>
                            </select>
                        </div>
                        <input type="text" wire:model.blur="discount_value"
                               class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex justify-between text-xs text-slate-500 mt-1">
                            <span>{{ $discount_sign === 'discount' ? 'Desconto' : 'Acréscimo' }}</span>
                            <span>
                                @if($discount_sign === 'discount')−@else+@endif
                                R$ {{ number_format($this->discountAmount, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-3">
                        <div class="flex justify-between text-lg font-bold text-slate-800">
                            <span>Total</span>
                            <span>R$ {{ number_format($this->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Configurações</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                        <select wire:model="status"
                                class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="draft">Rascunho</option>
                            <option value="sent">Enviado</option>
                            <option value="approved">Aprovado</option>
                            <option value="rejected">Rejeitado</option>
                            <option value="expired">Expirado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Validade (dias)</label>
                        <input type="number" wire:model="valid_days" min="1"
                               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button wire:click="save" wire:loading.attr="disabled"
                        class="w-full bg-slate-700 hover:bg-slate-800 text-white px-4 py-3 rounded-lg text-sm font-medium transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">Salvar Rascunho</span>
                    <span wire:loading wire:target="save">Salvando...</span>
                </button>
                <button wire:click="saveAndPreview" wire:loading.attr="disabled"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg text-sm font-medium transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveAndPreview">Salvar e Visualizar</span>
                    <span wire:loading wire:target="saveAndPreview">Processando...</span>
                </button>
            </div>
        </div>
    </div>
</div>
