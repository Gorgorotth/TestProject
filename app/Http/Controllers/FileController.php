<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Requests\ZipStorePasswordRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use mysql_xdevapi\Exception;
use ZipArchive;

class FileController extends Controller
{
    public function index()
    {
        return view('file.index', [
            'files' => File::query()->latest()->where('user_id', auth()->id())->get(),
        ]);
    }

    public function create()
    {
        return view('file.create');
    }

    public function store(FileStoreRequest $request)
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

        File::query()->create([
            'user_id' => auth()->id(),
            'name' => $path,
        ]);

        return redirect('file');
    }


    public function edit($id)
    {
        return view('file.edit-zip', [
            'id' => $id
        ]);
    }

    public function storePassword(ZipStorePasswordRequest $request, $id)
    {
        $password = $request->password;
        $file = File::query()->firstWhere('id', $id);
        $zip = new ZipArchive();
        $zip_file = storage_path('app/public/archive/' . $file->name . '.zip');

        $zip_status = $zip->open($zip_file, ZipArchive::CREATE);
        $zip->setPassword($password);


        if ($zip_status === true) {

                $zip->setEncryptionName($file->name, ZipArchive::EM_AES_256, $password);

                    $zip->close();


        } else {
            die("Failed opening archive: " . @$zip->getStatusString() . " (code: " . $zip_status . ")");
        }
    }

    public function download($id)
    {
        $file = File::query()->firstWhere('id', $id);

        $zip_file = storage_path('app/public/archive/' . $file->name . '.zip');

        if (!file_exists($zip_file)) {

            die('file not found');

        } else {

            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$zip_file");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            readfile($zip_file);
        }

    }
//
//    public function update(FileUpdateRequest $request, $id)
//    {
//        if ($fileName = $request->fileName) {
//            dd($fileName);
//            Storage::disk('files')->move($fileName);
//            File::query()->firstWhere('id', $id)->update([
//                'name' => $request['fileName'],
//            ]);
//        }
//        return redirect('file');
//
//    }
//
//    public function destroy()
//    {
//
//    }


}
