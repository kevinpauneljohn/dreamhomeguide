<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view blog', only: ['index', 'show','getBlogs']),
            new Middleware('can:add blog', only: ['create', 'store']),
            new Middleware('can:edit blog', only: ['edit', 'update']),
            new Middleware('can:delete blog', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.blogs.index')->with([
            'title' => 'Blogs',
            'blogCategories' => $this->blogService->blogCategories(),
            'blogStatus' => $this->blogService->blogStatus(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.blogs.create')->with([
            'title' => 'Create Blog Post',
            'blogCategories' => $this->blogService->blogCategories(),
            'blogStatus' => $this->blogService->blogStatus(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        ///saving thumbnail
        if($request->hasFile('thumbnail'))
        {
            $photo = $request->file('thumbnail');
            $newName = time(). '-' . uniqid() . '.' . $photo->extension();
            $photo->move(public_path('storage/blogs'),$newName);
//
            $request->thumbnail = $newName;
        }

        ///
        $request->merge(['user_id' => auth()->user()->id]);
        $blogData = $request->only('title','slug','category','status','thumbnail','user_id','blog_content',
            'meta_title','meta_description','meta_keywords');
        $blog = Blog::create($blogData);

        return $blog->exists() ?
            response()->json(['success' => true, 'message' => 'Blog post created successfully.', 'slug' => $blog->slug]) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the blog post.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'test';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('dashboard.pages.blogs.edit')->with([
            'title' => 'Edit Blog Post',
            'blog' => $blog,
            'blogCategories' => $this->blogService->blogCategories(),
            'blogStatus' => $this->blogService->blogStatus(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): \Illuminate\Http\JsonResponse
    {
        $blog->fill($request->only('title','slug','category','status','blog_content','meta_title','meta_keywords','meta_description'));
        $isDirty = $blog->isDirty();

        if($isDirty)
        {
            $blog->save();
        }

        if($request->hasFile('thumbnail'))
        {
            $this->blogService->removeThumbnail($request, $blog->thumbnail);
            $photo = $request->file('thumbnail');
            $newName = time(). '-' . uniqid() . '.' . $photo->extension();
            $photo->move(public_path('storage/blogs'),$newName);
            $blog->update(['thumbnail' => $newName]);

            $isDirty = true;
        }

        if($isDirty)
        {
            return response()->json(['success' => true, 'message' => 'Blog post updated successfully.', ]);
        }

        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getBlogs(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->blogService->getBlogs($request->all());
    }


}
