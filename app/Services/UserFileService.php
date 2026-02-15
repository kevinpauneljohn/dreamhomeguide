<?php

namespace App\Services;

use App\Models\UserFile;
use Yajra\DataTables\Facades\DataTables;

class UserFileService
{
    public function getFiles($user_id)
    {
        return DataTables::of(UserFile::where('user_id', $user_id)->get())
            ->editColumn('updated_at', content: function ($files) {
                return $files->created_at->format('m-d-Y h:i a');
            })
            ->addColumn('action', content: function ($files) {
                return [
                    'view' => (bool)auth()->user()->can('view user'),
                    'delete' => auth()->user()->hasAnyRole(['super admin','manager']),
                    'id' => $files->id
                ];
            })
            ->make(true);
    }
}
