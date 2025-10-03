<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Jobs\ResizeImage;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\ImageService;
use App\ValueObjects\PostStatus;
use Illuminate\Container\Attributes\Storage;
use Intervention\Image\Laravel\Facades\Image;

class PostController extends Controller
{
    public function __construct(private ImageService $imageService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create',
        [
            'categories' => Category::all()
        ]
    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validate();

        $data['status'] = PostStatus::from($data['status'] ?? PostStatus::DRAFT);;

        Post::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Created Successfully',
            'text' => 'Post has been created successfully'
        ]);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit',  [
            'post' => $post,
            'tabs' => Tag::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        $data['status'] = PostStatus::from($data['status'] ?? PostStatus::DRAFT);

        if ($request->hasFile('image')) {
            $this->imageService->delete($post->image_path);

           ResizeImage::dispatch(
            $request->file('image')->store('posts', 'public'),
            800,
            600
        );

    }

        $tags = [];
        if ($request->tags) {
            foreach ($request->tags ?? [] as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                $tags[] = $tag->id;
            }
        }

        $post->tags()->sync($tags);

        $post->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Updated Successfully',
            'text' => 'Post has been updated successfully'
        ]);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Deleted Successfully',
            'text' => 'Post has been deleted successfully'
        ]);

        return redirect()->route('admin.posts.index');
    }
}
