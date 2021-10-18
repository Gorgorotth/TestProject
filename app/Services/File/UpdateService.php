<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class UpdateService
{
    public function update($request, $id)
    {
        $file = File::firstWhere('id', $id);

        $extension = pathinfo($file->name, PATHINFO_EXTENSION);

        Storage::disk('files')->move($file->name, $request->name . '.' . $extension);

        Storage::disk('archives')->move($file->zip_folder, $request->name . '.' . $extension . '.zip');

        $file->update([
            'name' => $request->name . '.' . $extension,
        ]);
    }
}
