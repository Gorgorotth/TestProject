<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    public function store($request)
    {
        $filename = ($request->file('file')->getClientOriginalName());

        if (!$request->fileName) {
            $path = $filename;
        } else {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            $path = $request->fileName . '.' . $extension;

            $filename = $request->fileName . '.' . $extension;
        }

        Storage::disk('files')->put($filename, $request->file('file')->getContent());

        File::create([
            'user_id' => auth()->id(),
            'name' => $path,
        ]);
    }
}
