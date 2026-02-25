<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">Editar Orçamento</h2>
    </x-slot>

    <livewire:budget-form :budget="$budget" />
</x-app-layout>
