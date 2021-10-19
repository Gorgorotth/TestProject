<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileService
{
    /**
     * @param $request
     */
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

    /**
     * @param $request
     * @param $id
     */
    public function storePassword($request, $id)
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

    /**
     * @param $id
     * @return array
     */
    public function download($id): array
    {
        $file = File::find($id);
        $zip_file = Storage::disk('archives')->path($file->zip_folder);
        $headers = [
            "Content-Type: application/zip",
        ];
        return ['zip_file' => $zip_file, 'file' => $file->zip_folder, 'headers' => $headers];
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $file = File::firstWhere('id', $id);
        $file->delete();
    }

    /**
     * @param $request
     * @param $id
     */
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