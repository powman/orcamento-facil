<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-slate-800">Orçamentos</h2>
        <a href="{{ route('budgets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            + Novo Orçamento
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Buscar por cliente ou número..."
                       class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select wire:model.live="statusFilter" class="border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos os status</option>
                    <option value="draft">Rascunho</option>
                    <option value="sent">Enviado</option>
                    <option value="approved">Aprovado</option>
                    <option value="rejected">Rejeitado</option>
                    <option value="expired">Expirado</option>
                </select>
            </div>
            <div>
                <input type="date" wire:model.live="dateFilter"
                       class="border border-slate-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        @if($budgets->isEmpty())
            <div class="px-6 py-16 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="font-medium">Nenhum orçamento encontrado.</p>
                <p class="text-sm mt-1">Crie o primeiro orçamento clicando em "+ Novo Orçamento".</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3">Número</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Data</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Valor Total</th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($budgets as $budget)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-slate-800 font-medium">
                                    {{ $budget->budget_number }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $budget->client_name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $budget->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colorMap = ['draft'=>'gray','sent'=>'blue','approved'=>'green','rejected'=>'red','expired'=>'yellow'];
                                        $color = $colorMap[$budget->status] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $budget->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-800 text-right">
                                    R$ {{ number_format($budget->total, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('budgets.print', $budget) }}" target="_blank"
                                           class="text-slate-500 hover:text-slate-700 text-xs px-2 py-1 rounded border border-slate-200 hover:border-slate-400 transition-colors">
                                            Imprimir
                                        </a>
                                        <a href="{{ route('budgets.edit', $budget) }}"
                                           class="text-blue-600 hover:text-blue-800 text-xs px-2 py-1 rounded border border-blue-200 hover:border-blue-400 transition-colors">
                                            Editar
                                        </a>
                                        <button wire:click="delete({{ $budget->id }})"
                                                wire:confirm="Tem certeza que deseja excluir este orçamento?"
                                                class="text-red-600 hover:text-red-800 text-xs px-2 py-1 rounded border border-red-200 hover:border-red-400 transition-colors">
                                            Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $budgets->links() }}
            </div>
        @endif
    </div>
</div>
