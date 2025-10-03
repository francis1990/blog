<x-layouts.admin>
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Edit</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <h1 class="text-3xl font-semibold mb-2">
        Edit Post
    </h1>
    <form
        action="{{ route('admin.posts.update', $post) }}"
        method="POST"
        class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="mb-6 relative">
            <figure>
                <img class="aspect-[16/9] object-cover object-center w-full"
                src="{{ $post->image }}"
                alt=""
                id="image-preview">
            </figure>

            <div class="absolute top-8 right-8">
                <label class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                    Upload image
                    <input name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(event, '#image-preview')"/>
                </label>
            </div>
        </div>

        <flux:input wire:model="title" label="Title" value="{{ old('title', $post->title)}}"/>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <flux:input wire:model="slug" label="Slug" value="{{ old('slug', $post->slug)}}"/>
        @error('slug')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
        <select id="category_id" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach($categories as $category)
            <option @selected(old('category_id',$post->category_id) == $post->category_id) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="max-w-sm mx-auto">
            <label for="tabs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">Tabs</label>
            <select multiple name="tabs[]" id="tabs[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach($tabs as $tab)
                <option value="{{ $tab->id }}">{{ $tab->name }}</option>
                @endforeach
            </select>
        </div>

        <flux:textarea wire:model="excerpt" label="Excerpt">{{ old('excerpt', $post->excerpt) }}</flux:textarea>
        @error('excerpt')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
        <div>
            <p class="font-medium mb-1"></p>
            <div id="editor">
                {!! old('content', $post->content) !!}
            </div>
        </div>
        <textarea class="hidden" name="content" id="content" cols="30" rows="10">{{ old('content', $post->content) }}</textarea>
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
            <!-- Campo hidden para enviar false si el checkbox no está marcado -->
            <input type="hidden" name="is_published" value="0">

            <!-- Checkbox -->
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_published" @checked(old('is_published', $post->is_published) == 1) value="1" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Publish</span>
            </label>
        </div>

        <div class="flex justify-end">
            <flux:button variant="primary" type="submit">Update post</flux:button>
        </div>
    </form>

    @push('js')
    <script>
        function previewImage(event, selector) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.querySelector(selector);
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
   <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
   <script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
    quill.on('text-change', function() {
        document.getElementById('content').value =  quill.root.innerHTML;;
    });
</script>
    @endpush

</x-layouts.admin>
