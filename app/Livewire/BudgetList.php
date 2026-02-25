<?php

namespace App\Livewire;

use App\Models\Budget;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $dateFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        session()->flash('success', 'Orçamento excluído com sucesso.');
    }

    public function render()
    {
        $budgets = Budget::with('client')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('client_name', 'like', "%{$this->search}%")
                    ->orWhere('budget_number', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFilter, fn ($q) => $q->whereDate('created_at', $this->dateFilter))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.budget-list', compact('budgets'));
    }
}
