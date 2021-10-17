<?php

namespace App\Observers;

use App\Events\FileCreated;
use App\Models\File;


class FileObserver
{
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function creating(File $file)
    {

    }

    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function created(File $file)
    {
        event(new FileCreated($file));

    }

    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function updated(File $file)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function deleted(File $file)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function restored(File $file)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param \App\Models\User $file
     * @return void
     */
    public function forceDeleted(File $file)
    {
        //
    }
}
