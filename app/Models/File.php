<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'user_id',
    ];

    /**
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getFilePathAttribute(): string
    {
        return Storage::disk('files')->url($this->name);
    }

    /**
     * @return string
     */
    public function getZipFolderAttribute(): string
    {
        return $this->name . '.zip';
    }
}
