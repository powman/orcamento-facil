<?php

namespace App\Livewire;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BudgetForm extends Component
{
    public ?Budget $budget = null;

    public string $clientSearch = '';

    public ?int $client_id = null;

    public string $client_name = '';

    public string $client_cpf_cnpj = '';

    public string $client_address = '';

    public string $status = 'draft';

    public int $valid_days = 7;

    public string $discount_type = 'money';

    public string $discount_sign = 'discount';

    public string $discount_value = '0,00';

    public string $notes = '';

    public array $items = [];

    public array $clientSuggestions = [];

    public bool $showClientSuggestions = false;

    protected function rules(): array
    {
        return [
            'client_name'           => 'nullable|string|max:255',
            'client_cpf_cnpj'       => 'nullable|string|max:18',
            'client_address'        => 'nullable|string|max:500',
            'status'                => 'required|in:draft,sent,approved,rejected,expired',
            'valid_days'            => 'required|integer|min:1',
            'discount_type'         => 'required|in:money,percent',
            'discount_sign'         => 'required|in:discount,surcharge',
            'discount_value'        => 'required',
            'notes'                 => 'nullable|string',
            'items'                 => 'required|array|min:1',
            'items.*.description'   => 'required|string|max:500',
            'items.*.quantity'      => 'required',
            'items.*.unit_price'    => 'required',
        ];
    }

    public function mount(?Budget $budget = null): void
    {
        if ($budget && $budget->exists) {
            $this->budget = $budget;
            $this->client_id = $budget->client_id;
            $this->client_name = $budget->client_name ?? '';
            $this->client_cpf_cnpj = $budget->client_cpf_cnpj ?? '';
            $this->client_address = $budget->client_address ?? '';
            $this->status = $budget->status;
            $this->valid_days = $budget->valid_days;
            $this->discount_type = $budget->discount_type;
            $this->discount_sign = $budget->discount_sign;
            $this->discount_value = number_format((float) $budget->discount_value, 2, ',', '.');
            $this->notes = $budget->notes ?? '';
            $this->items = $budget->items->map(fn ($item) => [
                'id'         => $item->id,
                'description' => $item->description,
                'quantity'   => number_format((float) $item->quantity, 3, ',', '.'),
                'unit_price' => number_format((float) $item->unit_price, 2, ',', '.'),
            ])->toArray();
        } else {
            $this->addItem();
        }
    }

    public function updatedClientSearch(): void
    {
        if (strlen($this->clientSearch) >= 2) {
            $this->clientSuggestions = Client::where('name', 'like', "%{$this->clientSearch}%")
                ->orWhere('cpf_cnpj', 'like', "%{$this->clientSearch}%")
                ->limit(5)
                ->get(['id', 'name', 'cpf_cnpj', 'address'])
                ->toArray();
            $this->showClientSuggestions = count($this->clientSuggestions) > 0;
        } else {
            $this->clientSuggestions = [];
            $this->showClientSuggestions = false;
        }
    }

    public function selectClient(int $id): void
    {
        $client = Client::find($id);
        if ($client) {
            $this->client_id = $client->id;
            $this->client_name = $client->name;
            $this->client_cpf_cnpj = $client->cpf_cnpj ?? '';
            $this->client_address = $client->address ?? '';
            $this->clientSearch = $client->name;
        }
        $this->showClientSuggestions = false;
        $this->clientSuggestions = [];
    }

    public function addItem(): void
    {
        $this->items[] = [
            'id'          => null,
            'description' => '',
            'quantity'    => '1,000',
            'unit_price'  => '0,00',
        ];
    }

    public function removeItem(int $index): void
    {
        array_splice($this->items, $index, 1);
        $this->items = array_values($this->items);
    }

    public function duplicateItem(int $index): void
    {
        $item = $this->items[$index];
        $item['id'] = null;
        array_splice($this->items, $index + 1, 0, [$item]);
        $this->items = array_values($this->items);
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)->sum(function ($item) {
            $qty = $this->parseDecimal($item['quantity'] ?? '0');
            $price = $this->parseDecimal($item['unit_price'] ?? '0');

            return $qty * $price;
        });
    }

    public function getTotalProperty(): float
    {
        $subtotal = $this->subtotal;
        $discount = $this->parseDecimal($this->discount_value ?? '0');

        if ($this->discount_sign === 'discount') {
            if ($this->discount_type === 'percent') {
                return $subtotal * (1 - $discount / 100);
            }

            return max(0, $subtotal - $discount);
        } else {
            if ($this->discount_type === 'percent') {
                return $subtotal * (1 + $discount / 100);
            }

            return $subtotal + $discount;
        }
    }

    public function getDiscountAmountProperty(): float
    {
        $subtotal = $this->subtotal;
        $discount = $this->parseDecimal($this->discount_value ?? '0');

        if ($this->discount_type === 'percent') {
            return $subtotal * $discount / 100;
        }

        return $discount;
    }

    private function parseDecimal(string $value): float
    {
        // Handle Brazilian decimal format: 1.234,56 -> 1234.56
        $value = trim($value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    public function save(bool $redirect = false): void
    {
        $this->validate();

        DB::transaction(function () use ($redirect) {
            $companyId = auth()->user()->company_id;
            $data = [
                'company_id'       => $companyId,
                'client_id'        => $this->client_id,
                'client_name'      => $this->client_name,
                'client_cpf_cnpj'  => $this->client_cpf_cnpj,
                'client_address'   => $this->client_address,
                'status'           => $this->status,
                'valid_days'       => $this->valid_days,
                'discount_type'    => $this->discount_type,
                'discount_sign'    => $this->discount_sign,
                'discount_value'   => $this->parseDecimal($this->discount_value),
                'notes'            => $this->notes,
            ];

            if ($this->budget && $this->budget->exists) {
                $this->budget->update($data);
            } else {
                $data['budget_number'] = Budget::generateNumber($companyId);
                $this->budget = Budget::create($data);
            }

            // Sync items
            $existingIds = [];
            foreach ($this->items as $index => $item) {
                $itemData = [
                    'description' => $item['description'],
                    'quantity'    => $this->parseDecimal($item['quantity']),
                    'unit_price'  => $this->parseDecimal($item['unit_price']),
                    'sort_order'  => $index,
                ];
                if (! empty($item['id'])) {
                    $bi = BudgetItem::find($item['id']);
                    if ($bi && $bi->budget_id === $this->budget->id) {
                        $bi->update($itemData);
                        $existingIds[] = $bi->id;
                        continue;
                    }
                }
                $bi = $this->budget->items()->create($itemData);
                $existingIds[] = $bi->id;
            }
            // Remove deleted items
            $this->budget->items()->whereNotIn('id', $existingIds)->delete();
        });

        if ($redirect) {
            $this->redirect(route('budgets.print', $this->budget), navigate: true);
        } else {
            session()->flash('success', 'Orçamento salvo com sucesso!');
            $this->redirect(route('budgets.edit', $this->budget), navigate: true);
        }
    }

    public function saveAndPreview(): void
    {
        $this->save(true);
    }

    public function render()
    {
        return view('livewire.budget-form');
    }
}
