<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanySettings extends Component
{
    use WithFileUploads;

    public ?Company $company = null;

    public string $name = '';

    public string $trade_name = '';

    public string $cnpj = '';

    public string $phone1 = '';

    public string $phone2 = '';

    public string $email = '';

    public string $website = '';

    public string $address = '';

    public string $neighborhood = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public $logo = null;

    public array $services = [];

    public string $newService = '';

    protected function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'trade_name'   => 'nullable|string|max:255',
            'cnpj'         => 'nullable|string|max:18',
            'phone1'       => 'nullable|string|max:20',
            'phone2'       => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'website'      => 'nullable|string|max:255',
            'address'      => 'nullable|string|max:500',
            'neighborhood' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'state'        => 'nullable|string|max:2',
            'zip_code'     => 'nullable|string|max:10',
            'logo'         => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        $this->company = auth()->user()->company;
        if ($this->company) {
            $this->name = $this->company->name;
            $this->trade_name = $this->company->trade_name ?? '';
            $this->cnpj = $this->company->cnpj ?? '';
            $this->phone1 = $this->company->phone1 ?? '';
            $this->phone2 = $this->company->phone2 ?? '';
            $this->email = $this->company->email ?? '';
            $this->website = $this->company->website ?? '';
            $this->address = $this->company->address ?? '';
            $this->neighborhood = $this->company->neighborhood ?? '';
            $this->city = $this->company->city ?? '';
            $this->state = $this->company->state ?? '';
            $this->zip_code = $this->company->zip_code ?? '';
            $this->services = $this->company->services->pluck('name')->toArray();
        }
    }

    public function addService(): void
    {
        if (trim($this->newService)) {
            $this->services[] = trim($this->newService);
            $this->newService = '';
        }
    }

    public function removeService(int $index): void
    {
        array_splice($this->services, $index, 1);
        $this->services = array_values($this->services);
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'         => $this->name,
            'trade_name'   => $this->trade_name,
            'cnpj'         => $this->cnpj,
            'phone1'       => $this->phone1,
            'phone2'       => $this->phone2,
            'email'        => $this->email,
            'website'      => $this->website,
            'address'      => $this->address,
            'neighborhood' => $this->neighborhood,
            'city'         => $this->city,
            'state'        => $this->state,
            'zip_code'     => $this->zip_code,
        ];

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $data['logo_path'] = $path;
        }

        $this->company->update($data);

        // Sync services
        $this->company->services()->delete();
        foreach ($this->services as $serviceName) {
            $this->company->services()->create(['name' => $serviceName]);
        }

        session()->flash('success', 'Configurações salvas com sucesso!');
    }

    public function render()
    {
        return view('livewire.company-settings');
    }
}
