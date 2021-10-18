<?php

namespace App\Services\File;

use App\Models\File;

class DeleteService
{
    public function delete($id)
    {
        $file = File::firstWhere('id', $id);

        $file->delete();
    }
}
