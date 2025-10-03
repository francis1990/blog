<x-layouts.admin>

    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>New</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <h1 class="text-3xl font-semibold mb-2">
        New Post
    </h1>
    <form action="{{ route('admin.posts.store') }}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf
        <flux:input wire:model="title" label="Title" value="{{ old('title')}}"/>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <flux:input wire:model="slug" label="Slug" value="{{ old('slug')}}"/>
        @error('slug')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <flux:select wire:model="category_id" label="Category" placeholder="Choose category...">
            @foreach($categories as $category)
                <flux:select.option
                    value="{{ $category->id }}">
                    {{ $category->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:textarea wire:model="excerpt" label="Excerpt">{{ old('excerpt') }}</flux:textarea>
        @error('excerpt')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <flux:textarea wire:model="content" rows="12" label="Content">{{ old('content') }}</flux:textarea>
        @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            @foreach (App\ValueObjects\PostStatus::validStatuses() as $status)
                <option value="{{ $status }}" @selected(old('status', $post->status->value() ?? 'draft') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <div class="mb-4">
            <input type="hidden" name="is_published" value="0">
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_published" value="{{ old('is_published')}}" class="sr-only peer">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Publish</span>
        </label>
        </div>

        <div class="flex justify-end">
            <flux:button variant="primary" type="submit">Create post</flux:button>
        </div>
    </form>

</x-layouts.admin>
