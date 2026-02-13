<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use App\Http\Requests\StoreUserFileRequest;
use App\Http\Requests\UpdateUserFileRequest;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserFileRequest $request)
    {
        if($request->hasFile('file'))
        {
            $file = $request->file('file');

            $destination = public_path('/storage/files');
            $thumbnailPath    = public_path('/storage/files/thumbs');

            if(!File::exists($destination))
            {
                File::ensureDirectoryExists($destination);
            }

            if (!File::exists($thumbnailPath)) {
                File::ensureDirectoryExists($thumbnailPath);
            }

            /* ------------------------------------------
            | ORIGINAL NAME PARTS
            ------------------------------------------ */
            $originalName = $file->getClientOriginalName();
            $nameOnly     = pathinfo($originalName, PATHINFO_FILENAME);
            $extension    = $file->getClientOriginalExtension();

            /* ------------------------------------------
             | MAKE UNIQUE NAME
             ------------------------------------------ */
            $finalName = $originalName;
            $counter   = 1;

            while (File::exists($destination . '/' . $finalName)) {
                $finalName = $nameOnly . " ({$counter})." . $extension;
                $counter++;
            }

            /* ------------------------------------------
             | MOVE FILE
             ------------------------------------------ */
            $file->move($destination, $finalName);

            /* ------------------------------
            | GENERATE THUMBNAIL (IMAGES ONLY)
            ------------------------------ */
            $imageExtensions = ['jpg','jpeg','png','webp','gif'];

            if (in_array($extension, $imageExtensions)) {

                $manager = new ImageManager(new Driver());

                $image = $manager->read($destination . '/' . $finalName);

                // resize longest side to 300px
                $image->scaleDown(width: 300, height: 300);

                // encode based on original extension
                $encoded = match ($extension) {
                    'png'  => $image->toPng(),
                    'webp' => $image->toWebp(80),
                    default => $image->toJpeg(80),
                };

                file_put_contents($thumbnailPath . '/' . $finalName, $encoded);
            }

            if(UserFile::create([
                'user_id' => $request->user_id,
                'file_name' => $finalName,
                'extension' => $file->getClientOriginalExtension(),
            ]))
            {
                return response()->json(['success' => true, 'message' => 'File uploaded successfully.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'An error occurred while uploading the file.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFile $userFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserFile $userFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserFileRequest $request, UserFile $userFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFile $userFile)
    {
        //
    }

    public function getUserFiles($user)
    {
        return UserFile::where('user_id', $user)->get();
    }
}
