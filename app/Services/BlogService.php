<?php

namespace App\Services;

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

}
