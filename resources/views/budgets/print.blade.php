<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento {{ $budget->budget_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #f8fafc;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 10mm 12mm;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 10px;
            margin-bottom: 8px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .company-logo {
            max-width: 80px;
            max-height: 60px;
            object-fit: contain;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a5f;
            line-height: 1.2;
        }

        .company-trade {
            font-size: 12px;
            color: #475569;
        }

        .header-right {
            text-align: right;
            color: #475569;
            font-size: 11px;
            line-height: 1.6;
        }

        /* Services Banner */
        .services-banner {
            background: #1e3a5f;
            color: white;
            padding: 6px 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
            font-size: 10px;
        }

        .services-banner span {
            padding: 2px 8px;
            border-right: 1px solid rgba(255,255,255,0.3);
        }

        .services-banner span:last-child {
            border-right: none;
        }

        /* Budget Title */
        .budget-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .budget-title h1 {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .budget-number {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Client Box */
        .client-box {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 10px;
            background: #f8fafc;
        }

        .client-box-title {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .client-row {
            display: flex;
            gap: 20px;
        }

        .client-field {
            flex: 1;
        }

        .client-field label {
            font-size: 9px;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }

        .client-field .value {
            font-size: 12px;
            color: #1e293b;
            font-weight: 500;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .items-table thead tr {
            background: #1e3a5f;
            color: white;
        }

        .items-table thead th {
            padding: 7px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table thead th.text-right {
            text-align: right;
        }

        .items-table thead th.text-center {
            text-align: center;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f1f5f9;
        }

        .items-table tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .items-table tbody td.text-right {
            text-align: right;
        }

        .items-table tbody td.text-center {
            text-align: center;
        }

        /* Totals */
        .totals-area {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .totals-box {
            width: 260px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            overflow: hidden;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 12px;
            font-size: 11px;
            border-bottom: 1px solid #e2e8f0;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-row.label {
            color: #64748b;
        }

        .totals-row.discount {
            color: #dc2626;
        }

        .totals-row.surcharge {
            color: #16a34a;
        }

        .totals-row.total {
            background: #1e3a5f;
            color: white;
            font-weight: bold;
            font-size: 13px;
            padding: 8px 12px;
        }

        /* Notes */
        .notes-box {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .notes-box-title {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        /* Validity */
        .validity-box {
            background: #fef9c3;
            border: 1px solid #fde047;
            border-radius: 4px;
            padding: 6px 12px;
            margin-bottom: 15px;
            font-size: 11px;
            color: #713f12;
            text-align: center;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #334155;
            margin-bottom: 5px;
            padding-top: 5px;
        }

        .signature-label {
            font-size: 10px;
            color: #64748b;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }

        /* Print button */
        .print-btn-area {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
        }

        .btn-primary {
            background: #1e3a5f;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        @media print {
            body { background: white; }
            .page { box-shadow: none; margin: 0; }
            .print-btn-area { display: none; }
        }
    </style>
</head>
<body>

    <!-- Print/Back buttons (hidden when printing) -->
    <div class="print-btn-area">
        <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-secondary">← Voltar</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir / PDF</button>
    </div>

    <div class="page">

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                @if($budget->company->logo_path)
                    <img src="{{ Storage::url($budget->company->logo_path) }}" alt="{{ $budget->company->name }}" class="company-logo">
                @endif
                <div>
                    <div class="company-name">{{ $budget->company->trade_name ?? $budget->company->name }}</div>
                    @if($budget->company->trade_name)
                        <div class="company-trade">{{ $budget->company->name }}</div>
                    @endif
                    @if($budget->company->cnpj)
                        <div style="font-size:10px; color:#64748b; margin-top:2px;">CNPJ: {{ $budget->company->cnpj }}</div>
                    @endif
                </div>
            </div>
            <div class="header-right">
                @if($budget->company->phone1)
                    <div>📞 {{ $budget->company->phone1 }}</div>
                @endif
                @if($budget->company->phone2)
                    <div>📱 {{ $budget->company->phone2 }}</div>
                @endif
                @if($budget->company->email)
                    <div>✉️ {{ $budget->company->email }}</div>
                @endif
                @if($budget->company->website)
                    <div>🌐 {{ $budget->company->website }}</div>
                @endif
                @if($budget->company->address)
                    <div style="margin-top:3px;">
                        {{ $budget->company->address }}
                        @if($budget->company->neighborhood), {{ $budget->company->neighborhood }}@endif
                    </div>
                    @if($budget->company->city)
                        <div>{{ $budget->company->city }}@if($budget->company->state) – {{ $budget->company->state }}@endif
                        @if($budget->company->zip_code) – CEP {{ $budget->company->zip_code }}@endif</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Services Banner -->
        @if($budget->company->services->count() > 0)
            <div class="services-banner">
                @foreach($budget->company->services as $service)
                    <span>{{ $service->name }}</span>
                @endforeach
            </div>
        @endif

        <!-- Budget Title -->
        <div class="budget-title">
            <h1>Orçamento</h1>
            <div class="budget-number">
                Nº {{ $budget->budget_number }} &nbsp;|&nbsp;
                Data: {{ $budget->created_at->format('d/m/Y') }} &nbsp;|&nbsp;
                Validade: {{ $budget->valid_days }} dias
                @if($budget->expires_at)
                    (até {{ $budget->expires_at->format('d/m/Y') }})
                @endif
            </div>
        </div>

        <!-- Client -->
        <div class="client-box">
            <div class="client-box-title">Dados do Cliente</div>
            <div class="client-row">
                <div class="client-field" style="flex: 2;">
                    <label>Nome</label>
                    <div class="value">{{ $budget->client_name ?? '—' }}</div>
                </div>
                @if($budget->client_cpf_cnpj)
                    <div class="client-field">
                        <label>CPF / CNPJ</label>
                        <div class="value">{{ $budget->client_cpf_cnpj }}</div>
                    </div>
                @endif
                @if($budget->client_address)
                    <div class="client-field" style="flex: 2;">
                        <label>Endereço</label>
                        <div class="value">{{ $budget->client_address }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        @php
            $subtotal = $budget->items->sum(fn($item) => (float)$item->quantity * (float)$item->unit_price);
            $discountVal = (float) $budget->discount_value;
            if ($budget->discount_type === 'percent') {
                $discountAmount = $subtotal * $discountVal / 100;
            } else {
                $discountAmount = $discountVal;
            }
            $total = $budget->discount_sign === 'discount'
                ? max(0, $subtotal - $discountAmount)
                : $subtotal + $discountAmount;
        @endphp

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px;" class="text-center">#</th>
                    <th>Descrição</th>
                    <th class="text-center" style="width: 80px;">Qtd</th>
                    <th class="text-right" style="width: 100px;">Preço Unit.</th>
                    <th class="text-right" style="width: 110px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($budget->items as $index => $item)
                    <tr>
                        <td class="text-center" style="color: #94a3b8;">{{ $index + 1 }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">{{ number_format((float)$item->quantity, 3, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format((float)$item->unit_price, 2, ',', '.') }}</td>
                        <td class="text-right" style="font-weight: 600;">
                            R$ {{ number_format((float)$item->quantity * (float)$item->unit_price, 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#94a3b8; padding: 20px;">Nenhum item.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-area">
            <div class="totals-box">
                <div class="totals-row label">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
                @if($discountAmount > 0)
                    <div class="totals-row {{ $budget->discount_sign === 'discount' ? 'discount' : 'surcharge' }}">
                        <span>
                            {{ $budget->discount_sign === 'discount' ? '− Desconto' : '+ Acréscimo' }}
                            @if($budget->discount_type === 'percent')
                                ({{ number_format($discountVal, 1, ',', '.') }}%)
                            @endif
                        </span>
                        <span>R$ {{ number_format($discountAmount, 2, ',', '.') }}</span>
                    </div>
                @endif
                <div class="totals-row total">
                    <span>TOTAL</span>
                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($budget->notes)
            <div class="notes-box">
                <div class="notes-box-title">Observações</div>
                <div>{{ $budget->notes }}</div>
            </div>
        @endif

        <!-- Validity Notice -->
        <div class="validity-box">
            ⚠️ Este orçamento é válido por <strong>{{ $budget->valid_days }} dias</strong> a partir da data de emissão
            ({{ $budget->created_at->format('d/m/Y') }}).
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-box">
                <div style="height: 40px;"></div>
                <div class="signature-line"></div>
                <div style="font-weight: 600; font-size: 11px;">{{ $budget->company->trade_name ?? $budget->company->name }}</div>
                <div class="signature-label">Empresa / Responsável</div>
            </div>
            <div class="signature-box">
                <div style="height: 40px;"></div>
                <div class="signature-line"></div>
                <div style="font-weight: 600; font-size: 11px;">{{ $budget->client_name ?? 'Cliente' }}</div>
                <div class="signature-label">Cliente / Contratante</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Orçamento gerado em {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp;
            {{ $budget->company->trade_name ?? $budget->company->name }}
            @if($budget->company->cnpj)
                &nbsp;|&nbsp; CNPJ: {{ $budget->company->cnpj }}
            @endif
        </div>

    </div>

</body>
</html>
