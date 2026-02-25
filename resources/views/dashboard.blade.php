<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">Dashboard</h2>
    </x-slot>

    @php
        $company = auth()->user()->company;
        $totalBudgets = \App\Models\Budget::count();
        $approvedBudgets = \App\Models\Budget::where('status', 'approved')->count();
        $draftBudgets = \App\Models\Budget::where('status', 'draft')->count();
        $monthTotal = \App\Models\Budget::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('items')
            ->get()
            ->sum(fn($b) => $b->total);
        $recentBudgets = \App\Models\Budget::with('client')->orderByDesc('created_at')->limit(5)->get();
    @endphp

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $totalBudgets }}</div>
                    <div class="text-sm text-slate-500">Total de Orçamentos</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $approvedBudgets }}</div>
                    <div class="text-sm text-slate-500">Aprovados</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $draftBudgets }}</div>
                    <div class="text-sm text-slate-500">Pendentes</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">R$ {{ number_format($monthTotal, 2, ',', '.') }}</div>
                    <div class="text-sm text-slate-500">Valor Total do Mês</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Budgets -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Últimos Orçamentos</h3>
            <a href="{{ route('budgets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                + Novo Orçamento
            </a>
        </div>

        @if($recentBudgets->isEmpty())
            <div class="px-6 py-12 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Nenhum orçamento criado ainda.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3">Número</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Data</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentBudgets as $budget)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-slate-800">{{ $budget->budget_number }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $budget->client_name ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $budget->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = ['draft'=>'gray','sent'=>'blue','approved'=>'green','rejected'=>'red','expired'=>'yellow'];
                                        $color = $colors[$budget->status] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $budget->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-800 text-right">
                                    R$ {{ number_format($budget->total, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('budgets.edit', $budget) }}" class="text-blue-600 hover:text-blue-800 text-sm">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
