<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">Categories</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>New</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf
        <flux:input wire:model="name" label="Name" value="{{ old('name')}}"/>
        <div class="flex justify-end">
            <flux:button variant="primary" type="submit">Save</flux:button>
        </div>
    </form>

</x-layouts.admin>
