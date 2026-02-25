<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $cpf_cnpj = '';

    public string $phone = '';

    public string $email = '';

    public string $address = '';

    protected function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'cpf_cnpj' => 'nullable|string|max:18',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',
            'address'  => 'nullable|string|max:500',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->reset(['editingId', 'name', 'cpf_cnpj', 'phone', 'email', 'address']);
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $client = Client::findOrFail($id);
        $this->editingId = $id;
        $this->name = $client->name;
        $this->cpf_cnpj = $client->cpf_cnpj ?? '';
        $this->phone = $client->phone ?? '';
        $this->email = $client->email ?? '';
        $this->address = $client->address ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'company_id' => auth()->user()->company_id,
            'name'       => $this->name,
            'cpf_cnpj'   => $this->cpf_cnpj,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'address'    => $this->address,
        ];

        if ($this->editingId) {
            Client::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Cliente atualizado com sucesso!');
        } else {
            Client::create($data);
            session()->flash('success', 'Cliente criado com sucesso!');
        }
        $this->showForm = false;
        $this->reset(['editingId', 'name', 'cpf_cnpj', 'phone', 'email', 'address']);
    }

    public function delete(int $id): void
    {
        Client::findOrFail($id)->delete();
        session()->flash('success', 'Cliente excluído com sucesso!');
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->reset(['editingId', 'name', 'cpf_cnpj', 'phone', 'email', 'address']);
    }

    public function render()
    {
        $clients = Client::when($this->search, fn ($q) => $q->where(function ($q) {
            $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('cpf_cnpj', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%");
        }))->orderBy('name')->paginate(15);

        return view('livewire.client-list', compact('clients'));
    }
}
