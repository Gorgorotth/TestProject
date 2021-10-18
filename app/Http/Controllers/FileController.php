<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Requests\ZipStorePasswordRequest;
use App\Models\File;
use App\Services\FileService;


class FileController extends Controller
{
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('file.index', [
            'files' => File::latest()->where('user_id', auth()->id())->get(),
        ]);
    }

    public function create()
    {
        return view('file.create');
    }

    public function store(FileStoreRequest $request)
    {
        try {
            $this->service->store($request);
            return redirect(route('file.index'))->with('success', 'You added new file');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }


    public function edit($id)
    {
        $file = File::firstWhere('id', $id);
        return view('file.edit-zip', [
            'id' => $id,
            'file' => $file,
        ]);
    }

    public function edit_file($id)
    {
        $file = File::firstWhere('id', $id);
        return view('file.edit', [
            'file' => $file
        ]);
    }

    public function store_password(ZipStorePasswordRequest $request, $id)
    {
        try {
            $this->service->store_password($request, $id);
            return redirect(route('file.index'))->with('success', 'You added a password');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }

    public function download($id)
    {
        try {
            $service = $this->service->download($id);
            return response()->download($service['zip_file'], $service['file'], $service['headers']);;
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
            return back()->with('success', 'File is deleted');
        } catch (\Exception $e) {
            return redirect('file.index')->with('error', 'Something went wrong');
        }
    }


    public function update(FileUpdateRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
            return redirect(route('file.index'))->with('success', 'You renamed a file');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Name already exist, choose another one');
        }
    }
}
