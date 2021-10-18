<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Requests\ZipStorePasswordRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
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

        return redirect('/file')->with('success', 'You added new file');
    }


    public function edit($id)
    {
        $file = File::query()->firstWhere('id', $id);
        return view('file.edit-zip', [
            'id' => $id,
            'file' => $file,
        ]);
    }

    public function edit_file($id)
    {
        $file = File::query()->firstWhere('id', $id);
        return view('file.edit', [
            'file' => $file
        ]);
    }

    public function store_password(ZipStorePasswordRequest $request, $id)
    {
        $password = $request->password;
        $file = File::query()->firstWhere('id', $id);
        $zip = new ZipArchive();
        $zip_file = storage_path('app/public/' . $file->zip_folder);

        try {

            $zip_status = $zip->open($zip_file, ZipArchive::CREATE);

            $zip->setPassword($password);


            if ($zip_status === true) {

                $zip->setEncryptionName($file->name, ZipArchive::EM_AES_256, $password);

                $zip->close();


                return redirect('/file')->with('success', 'You added a password');
            }
        } catch (\Exception $e){
            return redirect('/file')->with('error', 'Something went wrong');
        }


    }

    public function download($id)
    {
        $file = File::query()->firstWhere('id', $id);

        $zip_file = storage_path('app/public/' . $file->zip_folder);
        if (!file_exists($zip_file)) {

            return redirect('/file')->with('error','file not found');

        } else {

            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file->zip_folder");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            readfile($zip_file);


        }

    }

    public function delete($id)
    {

        $file = File::query()->firstWhere('id', $id);

        $file->delete();

        return back()->with('success', 'File is deleted');
    }


    public function update(FileUpdateRequest $request, $id)
    {
        $file = File::query()->firstWhere('id', $id);

        $extension = pathinfo($file->name, PATHINFO_EXTENSION);

        if ($fileName = $request->name) {

            Storage::disk('files')->move($file->name, $fileName . '.' . $extension);

            Storage::disk('archives')->move($file->zip_folder, $fileName . $extension . '.zip');

            $file->update([
                'name' => $fileName . '.' . $extension,
            ]);
        }
        return redirect('/file')->with('success', 'You renamed a file');

    }

}
