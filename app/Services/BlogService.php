<?php

namespace App\Services;

use App\Models\Blog;
use Yajra\DataTables\Facades\DataTables;

class BlogService
{
    public function blogCategories(): array
    {
        return [
            'real-estate-tips' => 'Real Estate Tips',
            'investment'       => 'Investment',
            'market-updates'   => 'Market Updates',
            'spotlights'       => 'Project Spotlights',
            'buying-guide'     => 'Buying Guide',
            'selling-guide'    => 'Selling Guide',
            'interior'         => 'Interior Designs',
            'laws'             => 'Real Estate Laws',
            'business'         => 'Business',
            'marketing'        => 'Marketing',
            'announcements'    => 'Announcements',
            'lifestyle'        => 'Lifestyle',
        ];
    }

    public function blogStatus(): array
    {
        return [
            'draft'     => ['label' => 'Draft', 'class' => 'bg-secondary'],
            'published' => ['label' => 'Published', 'class' => 'bg-success'],
            'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info'],
            'archived'  => ['label' => 'Archived', 'class' => 'bg-danger'],
            'unpublished' => ['label' => 'Unpublished', 'class' => 'bg-warning'],
        ];
    }

    public function findCategory(string $category): ?string
    {
        return $this->blogCategories()[$category] ?? null;
    }

    public function findStatus(string $leadStatus): ?array
    {
        foreach ($this->blogStatus() as $key => $item) {
            if (strcasecmp($item['label'], $leadStatus) === 0) {
                return [
                    'label' => $key,
                    'class' => $item['class'],
                ];
            }
        }

        return null;
    }

    public function blogQuery($request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Blog::query();

        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request['search']}%")
                    ->orWhere('blog_content', 'like', "%{$request['search']}%");
            });
        }

        //filter by status
        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        //filter by source
        if (!empty($request['category'])) {
            $query->where('category', $request['category']);
        }

        return $query;
    }
    public function getBlogs($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->blogQuery($request);
        return DataTables::of($query)
            ->editColumn('title', content: function ($blog) {
                return ucwords(strtolower($blog->title));
            })
            ->editColumn('user_id', content: function ($blog) {
                return ucwords(strtolower($blog->user->full_name));
            })
            ->editColumn('category', content: function ($blog) {
                return $this->findCategory($blog->category);
            })
            ->editColumn('status', content: function ($blog) {
                return $this->findStatus($blog->status);
            })
            ->editColumn('updated_at', content: function ($blog) {
                return $blog->updated_at->format('M d, Y g:i a');
            })
            ->addColumn('action', content: function ($blog) {
                return [
                    'view' => (bool)auth()->user()->can('view blog'),
                    'edit' => (bool)auth()->user()->can('edit blog'),
                    'delete' => (bool)auth()->user()->can('delete blog'),
                    'id' => $blog->id
                ];
            })
            ->make(true);
    }

    public function removeThumbnail($request, $thumbnail): void
    {
        if ($request->hasFile('thumbnail') && $thumbnail) {
            $path = public_path("storage/blogs/$thumbnail");

            if (file_exists($path)) unlink($path);
        }
    }

}
