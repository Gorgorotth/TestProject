<?php

namespace App\Listeners;

use App\Events\FileCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;

class ZipFile implements ShouldQueue
{
    use Queueable;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FileCreated $event)
    {
        $file = $event->file;
        $zip_file = Storage::disk('archives')->path($file->zip_folder);
        $zip = new Filesystem(new ZipArchiveAdapter(($zip_file)));
        $file_content = file_get_contents($file->file_path);
        $zip->put($file->name, $file_content);
        $zip->getAdapter()->getArchive()->close();
        $file->zipped = true;
        $file->save();
    }
}
