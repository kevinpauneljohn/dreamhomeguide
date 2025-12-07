<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.blogs.index')->with([
            'title' => 'Blogs',
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
    public function store(Request $request)
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
//        $blog = Blog::where('slug', $slug)->firstOrFail();
//        return view('pages.blog.post')->with([
//            'title' => ucwords(strtolower($blog->title)),
//            'blog' => $blog,
//        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
