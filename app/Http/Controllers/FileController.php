<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Requests\ZipStorePasswordRequest;
use App\Services\FileService;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    public $fileService;

    /**
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('file.index', [
            'files' => $this->fileService->getFiles(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * @param FileStoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FileStoreRequest $request)
    {
        try {
            $this->fileService->store($request);
            return redirect(route('file.index'))->with('success', 'You added new file');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        return view('file.edit-zip', [
            'id' => $id,
            'file' => $this->fileService->getFile($id),
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editFile($id)
    {
        return view('file.edit', [
            'file' => $this->fileService->getFile($id),
        ]);
    }

    /**
     * @param ZipStorePasswordRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storePassword(ZipStorePasswordRequest $request, $id)
    {
        try {
            $this->fileService->storePassword($request, $id);
            return redirect(route('file.index'))->with('success', 'You added a password');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        try {
            $service = $this->fileService->download($id);
            return response()->download($service['zip_file'], $service['file'], $service['headers']);
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Something went wrong');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        try {
            $this->fileService->delete($id);
            return back()->with('success', 'File is deleted');
        } catch (\Exception $e) {
            return redirect('file.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * @param FileUpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FileUpdateRequest $request, $id)
    {
        try {
            $this->fileService->update($request, $id);
            return redirect(route('file.index'))->with('success', 'You renamed a file');
        } catch (\Exception $e) {
            return redirect(route('file.index'))->with('error', 'Name already exist, choose another one');
        }
    }
}
