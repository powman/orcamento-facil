<div>
    <h2 class="text-xl font-bold text-slate-800 mb-6">Configurações da Empresa</h2>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Company Info -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Basic Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Informações da Empresa</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Razão Social *</label>
                        <input type="text" wire:model="name"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome Fantasia</label>
                        <input type="text" wire:model="trade_name"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">CNPJ</label>
                        <input type="text" wire:model="cnpj"
                               x-on:input="$event.target.value = maskCnpj($event.target.value)"
                               placeholder="00.000.000/0000-00"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telefone 1</label>
                        <input type="text" wire:model="phone1"
                               x-on:input="$event.target.value = maskPhone($event.target.value)"
                               placeholder="(00) 00000-0000"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telefone 2</label>
                        <input type="text" wire:model="phone2"
                               x-on:input="$event.target.value = maskPhone($event.target.value)"
                               placeholder="(00) 00000-0000"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                        <input type="email" wire:model="email"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Website</label>
                        <input type="text" wire:model="website"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Endereço</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Logradouro</label>
                        <input type="text" wire:model="address"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Bairro</label>
                        <input type="text" wire:model="neighborhood"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">CEP</label>
                        <input type="text" wire:model="zip_code"
                               x-on:input="$event.target.value = maskCep($event.target.value)"
                               placeholder="00000-000"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Cidade</label>
                        <input type="text" wire:model="city"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Estado (UF)</label>
                        <input type="text" wire:model="state" maxlength="2"
                               class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Logo -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Logo da Empresa</h3>

                @if($company?->logo_path)
                    <img src="{{ Storage::url($company->logo_path) }}" alt="Logo atual" class="w-full h-24 object-contain mb-3 border border-slate-100 rounded-lg p-2">
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Upload de Logo</label>
                    <input type="file" wire:model="logo" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Máx. 2MB. PNG, JPG ou SVG.</p>
                </div>
            </div>

            <!-- Services -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Serviços / Produtos</h3>
                <p class="text-xs text-slate-500 mb-3">Estes itens aparecem no cabeçalho dos orçamentos e podem ser selecionados ao criar itens.</p>

                <div class="space-y-2 mb-4">
                    @foreach($services as $index => $service)
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-2">
                            <div class="flex-1 min-w-0">
                                <span class="block text-sm text-slate-700 truncate">{{ $service['name'] }}</span>
                                @if(!empty($service['unit_price']))
                                    <span class="text-xs text-slate-500">R$ {{ number_format((float)$service['unit_price'], 2, ',', '.') }}</span>
                                @endif
                            </div>
                            <button type="button" wire:click="removeService({{ $index }})"
                                    class="text-red-400 hover:text-red-600 transition-colors flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-2">
                    <input type="text" wire:model="newServiceName"
                           placeholder="Nome do serviço/produto..."
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">R$</span>
                            <input type="text" wire:model="newServicePrice"
                                   x-on:input="$event.target.value = maskCurrency($event.target.value)"
                                   placeholder="0,00"
                                   class="w-full border border-slate-300 rounded-lg pl-9 pr-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" wire:click="addService"
                                class="bg-slate-700 hover:bg-slate-800 text-white px-3 py-2 rounded-lg text-sm transition-colors">
                            +
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <button wire:click="save" wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg text-sm font-medium transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Salvar Configurações</span>
                <span wire:loading wire:target="save">Salvando...</span>
            </button>
        </div>
    </div>
</div>
