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

        return redirect(route('file.index'))->with('success', 'You added new file');
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
        $zip_file = Storage::disk('archives')->path($file->zip_folder);

        try {

            $zip_status = $zip->open($zip_file, ZipArchive::CREATE);

            $zip->setPassword($password);


            if ($zip_status === true) {

                $zip->setEncryptionName($file->name, ZipArchive::EM_AES_256, $password);

                $zip->close();


                return redirect(route('file.index'))->with('success', 'You added a password');
            }
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }


    }

    public function download($id)
    {
        $file = File::query()->firstWhere('id', $id);
        $zip_file = Storage::disk('archives')->path($file->zip_folder);
        if (!file_exists($zip_file)) {

            return redirect(route('file.index'))->with('error', 'file not found');

        } else {


            $headers = [
                "Content-Type: application/zip",
            ];
            return response()->download($zip_file, $file->zip_folder, $headers);
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

            try {

                Storage::disk('files')->move($file->name, $fileName . '.' . $extension);

                Storage::disk('archives')->move($file->zip_folder, $fileName . '.' . $extension . '.zip');

                $file->update([
                    'name' => $fileName . '.' . $extension,
                ]);

                return redirect(route('file.index'))->with('success', 'You renamed a file');
            } catch (\Exception $e) {
                return redirect(route('file.index'))->with('error', 'Name already exist, choose another one');
            }
        }
    }

}
