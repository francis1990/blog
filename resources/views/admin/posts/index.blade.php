<x-layouts.admin>
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Posts</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-blue text-xs">New</a>
    </div>
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.posts.create')}}" class="text-white bg gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 mb-2 dark:gb-agray-800 dark:hover:bg-gray-700  dark:focus:ring-gray-700 text-sm dark:border-gray-700 ">
        New
    </a>
</div>
    <ul class="space-y-8">
        @foreach ($posts as $post)
        <li class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <a href="{{ route('admin.posts.edit', $post) }}">
                    <img class="aspect-[16/9] object-cover object-center w-full" src="{{$post->image}}" alt="">
                </a>
            </div>
            <div>
                <h1 class="text-xl font-semibold">
                    <a href="{{ route('admin.posts.edit', $post) }}">
                        {{ $post->title }}
                    </a>
                </h1>

                <hr class="mt-1 mb-2">

                <span @class([
                    'bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded' => $post->is_published,
                    'bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded' => !$post->is_published,
                ])>
                    {{ $post->is_published ? 'Published' : 'Draft' }}
                </span>

                <p class="text-gray-700 mt-2">
                    {{ Str::limit($post->excerpt, 100, '...') }}
                </p>

                <div class="flex space-x-2 justify-end mt-4">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs btn btn-green">Edit</a>
                    <hr class="mt-1 mb-2">
                <form class="delete-form-post" action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-xs btn btn-red">
                        Delete
                    </button></form>
                </div>

            </div>
        </li>

        @endforeach
    </ul>

    @push('js')
    <script>
        document.querySelectorAll('.delete-form-post').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                    cancelButtonText: "No, cancel!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                    });
            });
        });
    </script>
    @endpush

</x-layouts.admin>
