<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class StorePasswordService
{
    public function store_password($request, $id)
    {
        $password = $request->password;

        $file = File::firstWhere('id', $id);

        $zip = new ZipArchive();

        $zip_file = Storage::disk('archives')->path($file->zip_folder);

        $zip->open($zip_file, ZipArchive::CREATE);

        $zip->setPassword($password);

        $zip->setEncryptionName($file->name, ZipArchive::EM_AES_256, $password);

        $zip->close();
    }
}
