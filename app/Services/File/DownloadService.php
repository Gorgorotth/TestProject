<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class DownloadService
{
    public function download($id)
    {
        $file = File::firstWhere('id', $id);

        $zip_file = Storage::disk('archives')->path($file->zip_folder);

        $headers = [
            "Content-Type: application/zip",
        ];

        return response()->download($zip_file, $file->zip_folder, $headers);
    }
}
